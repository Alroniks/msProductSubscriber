{var $style = [
'logo' => 'display:block;margin: auto;',
'a' => 'color:#348eda;',
'p' => 'font-family: Arial;color: #666666;font-size: 12px;',
'h' => 'font-family:Arial;color: #111111;font-weight: 200;line-height: 1.2em;margin: 40px 20px;',
'h1' => 'font-size: 36px;',
'h2' => 'font-size: 28px;',
'h3' => 'font-size: 22px;',
'th' => 'font-family: Arial;text-align: left;color: #111111;',
'td' => 'font-family: Arial;text-align: left;color: #111111;',
]}

{var $site_url = ('site_url' | option) | preg_replace : '#/$#' : ''}
{var $assets_url = 'assets_url' | option}
{var $siteName = 'site_name' | option}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{$siteName}</title>
</head>
<body style="margin:0;padding:0;background:#ffffff;">
<div style="height:100%;padding-top:20px;background:#ffffff;">
    {block 'logo'}
        <a href="{$site_url}">
            <img style="{$style.logo}"
                 src="{$site_url}{$assets_url}components/msinformuser/img/web/msinformuser.png"
                 alt="{$site_url}"
                 width="160" height="120"/>
        </a>
    {/block}
    <!-- body -->
    <table class="body-wrap" style="padding:0 20px 20px 20px;width: 100%;background:#f6f6f6;margin-top:10px;">
        <tr>
            <td></td>
            <td class="container" style="border:1px solid #f0f0f0;background:#ffffff;width:800px;margin:auto;">
                <div class="content">
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <h3 style="{$style.h}{$style.h3}">
                                    {block 'title'}
                                        <h1>Доступные плейсхолдеры в шаблоне</h1>
                                    {/block}
                                </h3>

                                {block 'content'}
                                    <table style="width:90%;margin:auto;">
                                        <tr><th colspan="2">modResource Object (Все поля таблицы site_content)</th></tr>
                                        <tr><td>&#123;$id&#125;</td><td>{$id}</td></tr>
                                        <tr><td>&#123;$pagetitle&#125;</td><td>{$pagetitle}</td></tr>
                                        <tr><td>&#123;$longtitle&#125;</td><td>{$longtitle}</td></tr>
                                        <tr><td>&#123;$description&#125;</td><td>{$description}</td></tr>
                                        <tr><td>&#123;$alias&#125;</td><td>{$alias}</td></tr>
                                        <tr><td>&#123;$parent&#125;</td><td>{$parent}</td></tr>
                                        <tr><td>&#123;$introtext&#125;</td><td>{$introtext}</td></tr>
                                        <tr><td>&#123;$content&#125;</td><td>{$content}</td></tr>
                                        <tr><td>&#123;$template&#125;</td><td>{$template}</td></tr>
                                        <tr><td>&#123;$createdby&#125;</td><td>{$createdby}</td></tr>
                                        <tr><td>&#123;$createdon&#125;</td><td>{$createdon}</td></tr>
                                        <tr><td>&#123;$menutitle&#125;</td><td>{$menutitle}</td></tr>
                                        <tr><td>&#123;$class_key&#125;</td><td>{$class_key}</td></tr>
                                        <tr><td>&#123;$uri&#125;</td><td>{$uri}</td></tr>

                                        <tr><th colspan="2">msProductData Object (Все поля таблицы ms2_products)</th></tr>
                                        <tr><td>&#123;$product_article&#125;</td><td>{$product_article}</td></tr>
                                        <tr><td>&#123;$product_price&#125;</td><td>{$product_price}</td></tr>
                                        <tr><td>&#123;$product_old_price&#125;</td><td>{$product_old_price}</td></tr>
                                        <tr><td>&#123;$product_weight&#125;</td><td>{$product_weight}</td></tr>
                                        <tr><td>&#123;$product_image&#125;</td><td>{$product_image}</td></tr>
                                        <tr><td>&#123;$product_thumb&#125;</td><td>{$product_thumb}</td></tr>
                                        <tr><td>&#123;$product_vendor&#125;</td><td>{$product_vendor}</td></tr>
                                        <tr><td>&#123;$product_made_in&#125;</td><td>{$product_made_in}</td></tr>

                                        <tr><th colspan="2">msVendor Object (Все поля таблицы ms2_vendors)</th></tr>
                                        <tr><td>&#123;$vendor_id&#125;</td><td>{$vendor_id}</td></tr>
                                        <tr><td>&#123;$vendor_name&#125;</td><td>{$vendor_name}</td></tr>
                                        <tr><td>&#123;$vendor_resource&#125;</td><td>{$vendor_resource}</td></tr>
                                        <tr><td>&#123;$vendor_country&#125;</td><td>{$vendor_country}</td></tr>
                                        <tr><td>&#123;$vendor_logo&#125;</td><td>{$vendor_logo}</td></tr>
                                        <tr><td>&#123;$vendor_address&#125;</td><td>{$vendor_address}</td></tr>
                                        <tr><td>&#123;$vendor_phone&#125;</td><td>{$vendor_phone}</td></tr>
                                        <tr><td>&#123;$vendor_fax&#125;</td><td>{$vendor_fax}</td></tr>
                                        <tr><td>&#123;$vendor_email&#125;</td><td>{$vendor_email}</td></tr>
                                        <tr><td>&#123;$vendor_description&#125;</td><td>{$vendor_description}</td></tr>

                                        <tr><th colspan="2">Для всех рассылок кроме СООБЩИТЬ О ПОСТУПЛЕНИИ, или расширьте стандартный класс</th></tr>
                                        <tr><th colspan="2">modUserProfile Object (Все поля таблицы user_attributes)</th></tr>
                                        <tr><td>&#123;$profile_id&#125;</td><td>{$profile_id}</td></tr>
                                        <tr><td>&#123;$profile_internalKey&#125;</td><td>{$profile_internalKey}</td></tr>
                                        <tr><td>&#123;$profile_fullname&#125;</td><td>{$profile_fullname}</td></tr>
                                        <tr><td>&#123;$profile_email&#125;</td><td>{$profile_email}</td></tr>
                                        <tr><td>&#123;$profile_phone&#125;</td><td>{$profile_phone}</td></tr>
                                        <tr><td>&#123;$profile_mobilephone&#125;</td><td>{$profile_mobilephone}</td></tr>
                                        <tr><td>&#123;$profile_dob&#125;</td><td>{$profile_dob}</td></tr>
                                        <tr><td>&#123;$profile_gender&#125;</td><td>{$profile_gender}</td></tr>
                                        <tr><td>&#123;$profile_address&#125;</td><td>{$profile_address}</td></tr>
                                        <tr><td>&#123;$profile_country&#125;</td><td>{$profile_country}</td></tr>
                                        <tr><td>&#123;$profile_city&#125;</td><td>{$profile_city}</td></tr>
                                        <tr><td>&#123;$profile_state&#125;</td><td>{$profile_state}</td></tr>
                                        <tr><td>&#123;$profile_zip&#125;</td><td>{$profile_zip}</td></tr>
                                        <tr><td>&#123;$profile_fax&#125;</td><td>{$profile_fax}</td></tr>
                                        <tr><td>&#123;$profile_photo&#125;</td><td>{$profile_photo}</td></tr>
                                        <tr><td>&#123;$profile_comment&#125;</td><td>{$profile_comment}</td></tr>
                                        <tr><td>&#123;$profile_website&#125;</td><td>{$profile_website}</td></tr>
                                    </table>
                                {/block}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /content -->
            </td>
            <td></td>
        </tr>
    </table>
    <!-- /body -->
    <!-- footer -->
    <table style="clear:both !important;width: 100%;">
        <tr>
            <td></td>
            <td class="container">
                <!-- content -->
                <div class="content">
                    <table style="width:100%;text-align: center;">
                        <tr>
                            <td align="center">
                                <p style="{$style.p}">
                                    {block 'footer'}
                                        <a href="{$site_url}" style="color: #999999;">
                                            {$siteName}
                                        </a>
                                    {/block}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /content -->
            </td>
            <td></td>
        </tr>
    </table>
    <!-- /footer -->
</div>
</body>
</html>