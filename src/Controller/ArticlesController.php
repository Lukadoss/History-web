<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\FrozenTime;

require_once 'components/recaptchalib.php';

class ArticlesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('detail');
        $this->Auth->allow('newarticle');
    }

    function newarticle()
    {
        $this->loadModel('Districts');
        $district = $this->Districts->find('all');
        $this->set(compact("district"));
        //---
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

                $text_file = $this->request->data['text_file'];
                $image_file = $this->request->data['image_file'];
                $audio_file = $this->request->data['audio_file'];
                $video_file = $this->request->data['video_file'];

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

                    if ($text_size <= 15000000 && $image_size <= 30000000 && $audio_size <= 40000000 && $video_size <= 100000000 && $input_size<=150000000){
                        if ($this->Sources->save($source)) {
                            $text_validation = array("text/plain", "application/msword", "application/pdf",
                                "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/msword");
                            $image_validation = array("image/jpeg", "image/png", "image/gif", "image/bmp");
                            $audio_validation = array("audio/mpeg3", "audio/wav", "audio/x-wav", "audio/ogg", "audio/mpeg", "audio/x-mpeg-3", "video/x-mpeg", "audio/mp3");
                            $video_validation = array("video/avi", "video/mpeg", "video/mp4", "application/mp4", "video/x-msvideo");
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

                            $this->Flash->success(__('<strong>Příspěvek byl úspěšně nahrán!</strong> Počkejte, prosím, na jeho schválení.'));
                            return $this->redirect(['action' => 'new_article']);
                        }
                    }

                }

            }
            else {
                $this->Flash->error(__('<strong>Velikost tvých souborů přesáhl limit 150MB!</strong>'));
            }
            $this->Flash->error(__('<strong>Příspěvek se nepodařilo nahrát!</strong>'));
        }
        $this->set('source', $source);
    }

    function file_upload($file, $validation, $path){
        foreach ($file as $tmp) {
            if($tmp['name']!=null) {
                if (in_array($tmp['type'], $validation)) {
                    if (!is_dir($path)) {
                        if (!mkdir($path, 0777, true)) {
                            die('Failed to create folders...');
                        } else {
                            move_uploaded_file($tmp['tmp_name'], $path . '/' . $tmp['name']);
                        }
                    } else {
                        move_uploaded_file($tmp['tmp_name'], $path . '/' . $tmp['name']);
                    }

                } else {
                    $this->Flash->error(__('Neplatný typ pro soubor:' . $tmp['name']));
                }
            }
        }
    }

    function file_size($file)
    {
        $input_size = 0;
        foreach ($file as $f) {
            $input_size += $f['size'];
        }
        return $input_size;
    }

    function detail($prispevek_id)
    {
        $this->loadModel('Sources');
        $source = $this->Sources->get($prispevek_id);
        if (isset($source->user_id)) $articleAuthor = $this->Sources->Users->get($source->user_id);
        $this->set(compact('source'));
        $this->set(compact('articleAuthor'));
    }

    public function add()
    {
        $this->loadModel('Sources');
    }

    function edit()
    {

    }
}
