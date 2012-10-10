<?php
//Copyright (C) 2012  PoliticalColours.ro - Project of TheSponge.eu Some Rights Reserved.
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, either version 3 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.

include(root . 'lib/captcha/class.php');
include(root . 'lib/pagination.php');

$captcha    = new captcha();
$pagination = new pagination();

if (isset($_POST['trimite']))
{
    $valid = 1;
    
    if (strlen($_POST['nume']) == 0)
    {
        $nume_err = 'This field is mandatory.';
        $nume_class = 'visible';
        $valid = 0;
    }
    
    if ( $_POST['imagine'] != $captcha->returnCaptcha() )
    {
        $imagine_err = 'The code inserted is incorrect.';
        $imagine_class = 'visible';
        $valid = 0;
    }
    $captcha->refreshCaptcha();
    
    if ($valid == 1)
    {
        $existing = r(root . "data/feedback.txt");
        $data =
            str_replace(array("\t", "|"), "", $_POST['nume']) . "|" .
            str_replace(array("\t", "|"), "", $_POST['email']) . "|" .
            str_replace(array("\t", "|"), "", $_POST['website']) . "|" .
            str_replace(array("\t", "|"), "", $_POST['continut']);
        
        if (strlen($existing) > 0)
        {
            w(root . "data/feedback.txt", $data . "\t" . $existing);
        }
        else
        {
            w(root . "data/feedback.txt", $data);
        }
        
		ob_clean();
        header("location: ". conf::val('site_url') ."feedback.html");
        exit;
    }
    else
    {
        $nume       = $_POST['nume'];
        $email      = $_POST['email'];
        $website    = $_POST['website'];
        $continut   = $_POST['continut'];
    }
}

// Fetch the data
$data = r(root . 'data/feedback.txt');
$data = explode("\t", $data);
foreach ($data as $key=>$value)
{
    $parts = explode("|", $value);
    $data[$key] = $parts;
}

// Make the pagination
if (!is_numeric($_GET['pag'])) { $_GET['pag'] = 1; }
$total = count($data);
$to = 5;
$from = ($_GET['pag'] - 1) * $to;
$pagination_data = $pagination->navpag($total, $_GET['pag'], $to, 'feedback.html?', 'pag');

?>
<div class="wrapper_content">
    <h2>Feedback</h2>
    <div class="line">
        
        <div class="unit size2of5">
            <form action="" method="post">
                
                <div class="row">
                    <label for="nume" class="go">Name *</label>
                    <div>
                        <input type="text" class="text" name="nume" id="nume" value="<?php echo $nume; ?>"> <br>
                    </div>
                    <div class="error <?php echo $nume_class; ?>" id="err_nume"><?php echo $nume_err; ?></div>
                </div>
                <div class="row">
                    <label for="email" class="go">Email</label>
                    <div>
                        <input type="text" class="text" name="email" id="email" value="<?php echo $email; ?>"> <br>
                    </div>
                    <div class="error <?php echo $email_class; ?>" id="err_email"><?php echo $email_err; ?></div>
                </div>
                <div class="row">
                    <label for="website" class="go">Website</label>
                    <div>
                        <input type="text" class="text" name="website" id="website" value="<?php echo $website; ?>"> <br>
                    </div>
                    <div class="error <?php echo $website_class; ?>" id="err_website"><?php echo $website_err; ?></div>
                </div>
                
                <div class="row margin-top-20">
                    <div>
                        <textarea type="text" class="text" name="continut" id="continut" rows="5" cols="50"><?php echo $continut; ?></textarea> <br>
                    </div>
                    <div class="error <?php echo $continut_class; ?>" id="err_continut"><?php echo $continut_err; ?></div>
                </div>
                
                <div class="row">
                    <label for="imagine" class="go">Security image</label>
                    <div>
                        <input type="text" class="text half" name="imagine" id="imagine" value="" autocomplete="off"> <br>
                    </div>
                    <div class="margin-top-10">
                        <img src="<?php echo conf::val('site_url'); ?>captcha.png?<?php echo time(); ?>">
                    </div>
                    <div class="error <?php echo $imagine_class; ?>" id="err_imagine"><?php echo $imagine_err; ?></div>
                </div>
                
                
                <div class="row margin-top-20">
                    <input type="submit" class="submit" name="trimite" value="Send">
                </div>
                
            </form>
        </div>
        
        <div class="unit size3of5 lastUnit">
            <h3>We have received feedback from..</h3>
            
            <?php if ( count($data) > 0 ): ?>
            <?php $a = 0; ?>
            <?php foreach ($data as $key=>$value): ?>
            <?php if ($a >= $from && $a < ($from + $to) ): ?>
            <div class="thanks">
                <?php if (strlen($value[2]) > 0): ?>
                <a href="<?php echo $value[2]; ?>"><?php echo $value[0]; ?></a>:<br>
                <?php else: ?>
                <?php echo $value[0]; ?>
                <?php endif; ?>
                
                <?php if (strlen($value[3]) > 0): ?>
                <div class="margin-top-10"><?php echo $value[3]; ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php $a++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if ( is_array($pagination_data) ):?>
            <div class="clear pagination margin-top-10">
                <ul>        
                    <?php foreach ($pagination_data['pages'] as $key=>$item): ?>
                        <?php
                            
                            if (strlen($item['link']) > 0)
                            {
                                echo '<li><a href="'.$item['link'].'" class="'.$item['class'].'">'.$item['name'].'</a></li>';
                            }
                            else
                            {
                                echo '<li class="'.$item['class'].'">'.$item['name'].'</li>';
                            }
                        ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
        </div>
        
    </div>
</div>