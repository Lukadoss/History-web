<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

use Cake\Event\Event;

require_once 'components/recaptchalib.php';

class ArticlesController extends AppController
{

    /**
     * Overrides beforeFilter in AppController
     * @param Event $event
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['detail', 'newarticle']);
        $this->Auth->config('authorize', ['Controller']);
    }

    /**
     * Creates new article
     */
    function newarticle()
    {
        $this->loadModel('Districts');
        $district = $this->Districts->find('all');
        $this->set(compact("district"));
        $file_count = 0;
        $this->loadModel('Sources');
        $source = $this->Sources->newEntity();

        if ($this->request->is('post')) {
            if ($_SERVER['CONTENT_LENGTH'] < 150000000) {
                $user_id = $this->Auth->user('user_id');
                $source->user_id = $user_id;

                $source->date_from = date('Y-m-d', strtotime($this->request->date_from));
                $secret = "6LdMihwTAAAAAMwgcps-oICkyK436ACqKcAemD5F";
                $recaptcha = new \ReCaptcha($secret);
                $response = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $this->request->data(['g-recaptcha-response']));
                if ($response->success) {
                    $source = $this->Sources->patchEntity($source, $this->request->data);
                    $source->date_from = $this->request->data('date_from');
                    $source->date_to = $this->request->data('date_to');
                    $source->name = htmlspecialchars($this->request->data('name'));
                    $source->text = htmlspecialchars($this->request->data('text'));
                    if($this->request->data('forename') || $this->request->data('surname') || $this->request->data('email')){
                        $source->forename = htmlspecialchars($this->request->data('forename'));
                        $source->surname = htmlspecialchars($this->request->data('surname'));
                        $source->email = htmlspecialchars($this->request->data('email'));
                    }

                    if (!empty($this->request->data['text_file'])) {
                        $text_file = $this->request->data['text_file'];
                        $file_count = $file_count + sizeof($text_file);
                    }
                    if (!empty($this->request->data['image_file'])) {
                        $image_file = $this->request->data['image_file'];
                        $file_count = $file_count + sizeof($image_file);
                    }
                    if (!empty($this->request->data['audio_file'])) {
                        $audio_file = $this->request->data['audio_file'];
                        $file_count = $file_count + sizeof($audio_file);
                    }
                    if (!empty($this->request->data['video_file'])) {
                        $video_file = $this->request->data['video_file'];
                        $file_count = $file_count + sizeof($video_file);
                    }

                    if ($file_count <= 19) {
                        $text_size = $this->file_size($text_file);
                        $image_size = $this->file_size($image_file);
                        $audio_size = $this->file_size($audio_file);
                        $video_size = $this->file_size($video_file);

                        $input_size = $text_size + $image_size + $audio_size + $video_size;
                        if ($text_size > 15000000) {
                            $this->Flash->error(__('<strong>Velikost dokumentů přesáhl limit 15MB</strong>'));
                        }
                        if ($image_size > 30000000) {
                            $this->Flash->error(__('<strong>Velikost obrázků přesáhl limit 30MB</strong>'));
                        }
                        if ($audio_size > 40000000) {
                            $this->Flash->error(__('<strong>Velikost audio souborů přesáhl limit 40MB</strong>'));
                        }
                        if ($video_size > 100000000) {
                            $this->Flash->error(__('<strong>Velikost video souborů přesáhl limit 100MB</strong>'));
                        }

                        if ($text_size <= 15000000 && $image_size <= 30000000 && $audio_size <= 40000000 && $video_size <= 100000000 && $input_size <= 150000000) {
                            $text_validation = array('pdf', 'doc', 'docx', 'txt');
                            $image_validation = array('jpg', 'jpeg', 'gif', 'bmp', 'png');
                            $audio_validation = array("mp3", "wav", "flac", "mpg");
                            $video_validation = array("mp4", "avi", "mpeg");

                            $result = $this->Sources->save($source);
                            $lastId = $result->source_id;

                            $path_text = 'files/' . $lastId . '/Text';
                            $path_audio = 'files/' . $lastId . '/Audio';
                            $path_video = 'files/' . $lastId . '/Video';
                            $path_image = 'files/' . $lastId . '/Image';

                            $this->file_upload($text_file, $text_validation, $path_text);
                            $this->file_upload($audio_file, $audio_validation, $path_audio);
                            $this->file_upload($video_file, $video_validation, $path_video);
                            $this->file_upload($image_file, $image_validation, $path_image);

                            if (is_dir($path_text)) $source->isText = 1;
                            if (is_dir($path_audio))$source->isAudio = 1;
                            if (is_dir($path_video))$source->isVideo = 1;
                            if (is_dir($path_image))$source->isImage = 1;

                            if ($this->Sources->save($source)) {

                                $this->Flash->success(__('<strong>Příspěvek byl nahrán!</strong> Nyní musí být potvrzen administrátorem.'));
                                return $this->redirect(['action' => 'new_article']);
                            }
                        }
                    } else {
                        $this->Flash->error(__('<strong>Přesáhnut limit 19 souborů!</strong>'));
                    }

                }
                $this->Flash->error(__('<strong>Captcha nebyla potvrzena!</strong>'));
            } else {
                $this->Flash->error(__('<strong>Velikost Vašich souborů přesáhl limit 150MB!</strong>'));
            }
            $this->Flash->error(__('<strong>Příspěvek se nepodařilo nahrát!</strong>'));
        }
        $this->set('source', $source);
    }

    /**
     * Uploads file to the server, checks validation of the file.
     * @param $file uploaded file
     * @param $validation validation rule
     * @param $path path to file
     */
    function file_upload($file, $validation, $path)
    {
        $transformation_array = Array(
            'ä'=>'a','Ä'=>'A','á'=>'a','Á'=>'A','à'=>'a','À'=>'A','ã'=>'a','Ã'=>'A','â'=>'a','Â'=>'A',
            'č'=>'c','Č'=>'C','ć'=>'c','Ć'=>'C','ď'=>'d','Ď'=>'D','ě'=>'e','Ě'=>'E','é'=>'e','É'=>'E',
            'ë'=>'e','Ë'=>'E','è'=>'e','È'=>'E','ê'=>'e', 'Ê'=>'E','í'=>'i','Í'=>'I','ï'=>'i','Ï'=>'I',
            'ì'=>'i','Ì'=>'I','î'=>'i','Î'=>'I','ľ'=>'l','Ľ'=>'L','ĺ'=>'l','Ĺ'=>'L','ń'=>'n','Ń'=>'N',
            'ň'=>'n','Ň'=>'N','ñ'=>'n','Ñ'=>'N','ó'=>'o','Ó'=>'O','ö'=>'o','Ö'=>'O','ô'=>'o','Ô'=>'O',
            'ò'=>'o','Ò'=>'O','õ'=>'o','Õ'=>'O','ő'=>'o','Ő'=>'O','ř'=>'r','Ř'=>'R','ŕ'=>'r','Ŕ'=>'R',
            'š'=>'s','Š'=>'S','ś'=>'s','Ś'=>'S','ť'=>'t','Ť'=>'T','ú'=>'u','Ú'=>'U','ů'=>'u','Ů'=>'U',
            'ü'=>'u','Ü'=>'U','ù'=>'u','Ù'=>'U','ũ'=>'u','Ũ'=>'U','û'=>'u','Û'=>'U','ý'=>'y','Ý'=>'Y',
            'ž'=>'z','Ž'=>'Z','ź'=>'z','Ź'=>'Z'
        );
        foreach ($file as $tmp) {
            if ($tmp['name'] != null) {
                if (in_array((strtolower(pathinfo($tmp["name"], PATHINFO_EXTENSION))), $validation)) {
                    if (!is_dir($path)) {
                        if (!mkdir($path, 0777, true)) {
                            die('Failed to create folders...');
                        } else {
    $tmp['name'] = strtr($tmp['name'], $transformation_array);

    move_uploaded_file($tmp['tmp_name'], $path . '/' . $tmp['name']);
}
} else {
    $tmp['name'] = strtr($tmp['name'], $transformation_array);
    move_uploaded_file($tmp['tmp_name'], $path . '/' . $tmp['name']);

}

} else {
    $this->Flash->error(__('Neplatný typ pro soubor:' . $tmp['name']));
}
}
}
}

/**
 * File size of sigle entities (images, videos, documents, audio)
 * @param $file file entity
 * @return int size of files
 */
function file_size($file)
{
    $input_size = 0;
    foreach ($file as $f) {
        $input_size += $f['size'];
    }
    return $input_size;
}

/**
 * Shows detail of single article
 * @param null $prispevek_id article id
 */
function detail($prispevek_id = null)
    {
        if ($prispevek_id!=null) {
            $this->loadModel('Sources');
            $source = $this->Sources->get($prispevek_id);
            if ($source && isset($source->user_id)) {
                $articleAuthor = $this->Sources->Users->get($source->user_id);
            }
        }else{
            $this->redirect($this->Auth->redirectUrl());
        }

        $this->set(compact('source'));
        $this->set(compact('articleAuthor'));
    }

    /**
     * Gives power to admin or author to edit the article
     * @param null $prispevek_id article id
     */
    function edit($prispevek_id = null)
    {
        if ($prispevek_id) {
            $this->loadModel('Sources');
            $source = $this->Sources->get($prispevek_id);
            if ($source && isset($source->user_id)) {
                $articleAuthor = $this->Sources->Users->get($source->user_id);
            } else {
                $articleAuthor = null;
            }
            $this->set(compact('source'));
            $this->set(compact('articleAuthor'));

            $this->loadModel('Users');
            $user = $this->Users->get($this->Auth->user('user_id'));
            if (!$this->checkAuthorized($user, $articleAuthor)) {
                $this->redirect($this->Auth->redirectUrl());
            }

            if ($this->request->is('post')) {
                $this->Sources->patchEntity($source, $this->request->data);
                $source->date_from = $this->request->data('date_from');
                $source->date_to = $this->request->data('date_to');
                if ($user->isadmin != true){
                    $source->onHold = true;
                }

                if ($this->Sources->save($source)) {
                    $this->Flash->success('Příspěvek "' . htmlspecialchars($source->name) . '" byl úspěšně změněn!');
                    if ($user->isadmin == true) $this->redirect($this->redirect(['controller' => 'administration']));
                    else $this->redirect($this->redirect(['controller' => 'users', 'action' => 'detail']));
                } else {
                    $this->Flash->error('Chyba při ukládání změn :(');
                }
            }
        }
    }

    /**
     * Overwrites isAuthorized function
     * @param null $user user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        if (isset($user)) {
            return true;
        }

        return false;
    }

    /**
     * Checks authorized person for editing an article
     * @param $user
     * @param $article
     * @return bool
     */
    public function checkAuthorized($user, $article)
    {
        if ($article) {
            if ($user->user_id === $article->user_id || $user->isadmin == true) {
                return true;
            }
        } else {
            if ($user->isadmin == true) {
                return true;
            }
        }
        return false;
    }
}
