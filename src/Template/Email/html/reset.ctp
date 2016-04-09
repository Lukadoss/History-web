<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<p>Byla nám zaslána žádost o změnu hesla. Pokud jste si tuto změnu nevyžádali, tento email ignorujte.</p><br/>
<p>Pro nové heslo klikněte na odkaz níže, který vás přesměruje na formulář pro změnu hesla.</p>
<a href="<?php echo $url; ?>"><?php echo $url; ?></a><br/>
<p>Tento odkaz bude platný po dobu 12 hodin, tj. do <?= date('d. m. Y H:i', strtotime('+12 hours')) ?></p><hr>
<p style="color: #818a91">Tento email byl vygenerován automaticky. Neodpovídejte na něj.</p>
