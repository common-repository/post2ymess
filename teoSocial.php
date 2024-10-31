<?php
/*
Plugin Name: Share Buttons for Social Networks: teoSocial
Plugin URI: http://goo.gl/3eBxl
Description:
This plugin adds the option to send a post to a friend, via Yahoo Messenger.
Recommend article via Facebook.
Follow twitter account or Tweet the article!
Share on Google+

Version:  5.4.4
Author: Teodor teo@zeitblog.com
Author URI: http://www.goo.gl/pr5IG
License:  GPL2
*/


/*  Copyright 2011  Teodor  (email : teodorstv@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

function teoSocial ($content = '') {

    $WP2YMSGR_PATH=WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__));


    $ret='';
    $ret = $content;
    $teoSocial = get_option('teoSocial');

    //----------- choose page type where to display the buttons : start
    if( (is_front_page()) && (! $teoSocial['onFrontPage'] )) { return $ret; }
    if( (is_page()      ) && (! $teoSocial['onPage']      )) { return $ret; }
    if( (is_category()  ) && (! $teoSocial['onCategory']  )) { return $ret; }
    if( (is_single()  ) && (! $teoSocial['onSingle']  )) { return $ret; }
    //----------- choose page type where to display the buttons : end


    $ret.= "<div id='teoShare'";
	if($teoSocial['right']){
		$ret .= " style='width:".$teoSocial['teoShareWidth']."px;'";
	}

	$ret .=	" >";
	
	$ret.= "<div id='zeit' style='background: none repeat scroll 0 0 #FFFFFF;
border: 1px solid #AAAAAA;
color: orange;
float: left;
height: 13px;
padding: 2px 1px 6px;
position: relative;
width: 40px;'>";

	$ret .="<a href='http://goo.gl/rqtAe' target='_blank' style='text-decoration:none;'>Share!</a>"; 
	$ret.= "</div>";
	
	
	if($teoSocial['enLi'] ){
		 /*teo Like button:start*/
		 $ret .='
				<div id="teoLike" style="width:'.$teoSocial['enLiWidth'].'px"><iframe src="http://www.facebook.com/plugins/like.php?href='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"
				scrolling="no" frameborder="0"
				style="border:none; width:'.$teoSocial['enLiWidth'].'; height:25px"></iframe>';
		 $ret .='</div>';
		/*teo Like button:end*/
    }
	
	if($teoSocial['enGo'] ){
		/*teo google+ start */
		$ret .= "<div id='teo2Google'>
		<!-- Place this tag where you want the +1 button to render -->
		<g:plusone size='tall' annotation='none'></g:plusone>

		<!-- Place this render call where appropriate -->
		<script type='text/javascript'>
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		</div>";
		 /*teo google+ end   */
     }


    
    if($teoSocial['enTw'] ){
		/*teo twitter tweet:start*/
                $tw = get_option('teoSocial');
                $tw = $tw['tw'];

		$ret .='<div id="teoTweet" >
		<a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="';
		$ret.=$tw.'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> </div>';
		/*teo twitter tweet:end*/
    }
    if($teoSocial['enFo']){
		/*teo twitter follow:start*/
		$ret .='<div id="teoTwFollow" >
		<a href="http://twitter.com/'.$tw.'" class="twitter-follow-button" data-show-count="false" data-width="'.$teoSocial["teoFollowWidth"].'px">Follow</a>
		<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script> </div>';
		 /*teo twitter follow:end  */ 
    }

	if($teoSocial['enYm'] ){
		/*teo yahoo: start*/
		$ret .="<div id='teo2Yahoo'><a alt='send to yahoo messenger' href='ymsgr:im?+&amp;msg=";
		//$ret.= "<a alt='send to yahoo messenger' href='ymsgr:im?+&amp;msg=";
		$ret.=get_the_title($post->ID);
		$ret.="  ";
		$ret.= get_permalink($post->ID);
		$ret.= "'><img src='".$WP2YMSGR_PATH."/post2ymess.png'></a>";
			$ret .="</div>";
		/*teo yahoo:end*/
    }
	
	$ret.='';
   	$ret.='</div>'; /*end teo social div end*/
    return $ret;
}


function writeCSS() {
        //$teoplpath=get_bloginfo('wpurl')."/wp-content/plugins/teoSocial";
        $teoplpath = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__));

	 $right = get_option('teoSocial');
         $right = $right['right'];

        
         

	 if($right == 1){
	  echo ( '<link rel="stylesheet" type="text/css" href="'. $teoplpath . '/teoSocial.css">' );
	  }else{
	  echo ( '<link rel="stylesheet" type="text/css" href="'. $teoplpath . '/teoSocialHoriz.css">' );
	  }
}

function teoSocialInstall() {
    $default = array(
        'tw'    => 'twitter account',
        'right' => '1',
        'enYm' => '1',
        'enTw' => '1',
        'enLi' => '1',
        'enFo' => '1',
        'enGo' => '1',
        'onPage' => '1',
        'onFrontPage' => '1',
        'onCategory' => '1',
        'onSingle' => '1',
		'enLiWidth' => '50',
		'teoShareWidth' => '50',
		'teoFollowWidth' => '150'
    );
	add_option("teoSocial", $default, '', 'yes');
}

function teoSocialRemove() {
	delete_option('teoSocial');
}

//--------------------------------------------------
//      settings page
//----------------------------------------------------
if ( is_admin() ){
    add_action('admin_menu', 'teoSocialAdminMenu');

    function teoSocialAdminMenu() {
        add_options_page('teoSocial', 'teoSocial Share', 'administrator','teoSocial', 'teoSocial_html_page');
    }
}



//----------------------------------------------------
//      admin interface page
//----------------------------------------------------
function teoSocial_html_page() {
    $temp  = get_option('teoSocial');
    $tw    = $temp['tw'];
    $right = $temp['right'];

    $teoSocial = get_option('teoSocial');
?>
<div>
    <h2>Options:Social Networks Share Buttons: teoSocial</h2>
    <div style=" float:right;
    margin-right:10px;
    background:#eee;
    padding:10px;
    width:230px;">
        <div  style="background: none repeat scroll 0 0 #F3F3F3;
    float: right;
    margin-right: 0;
    padding: 14px;
    width: 202px;">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="FF5T64VWFU9KW">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        <br />You have the chance to help me with a small donation
        </div>
        <div  style=" background: none repeat scroll 0 0 #FEFEFE;
    border: 5px solid lightgreen;
    float: right;
    margin: 1px;
    padding:4px;
    width: 200px;">
              Looking for <b>Discount Hosting?</b>
              <h2>Get 25% cheaper discount hosting with this coupon code:<br/> discounthosting25</h2>
              <a href="http://secure.hostgator.com/~affiliat/cgi-bin/affiliates/clickthru.cgi?id=t30aff-"><img border="0" src="http://tracking.hostgator.com/img/Discount_Shared/Hostgator-new-_AN-125x125.gif"></a>
        </div>
    </div>






    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <table>
            <tr>
                <td>
                    <table width="510">

                            <tr valign="top" style="background:#eee; border:1px solid efefef;">
                                <td colspan="2">Display buttons on the Right or After each Article?</td>
                            </tr>
                            <tr valign="top">
                                    <td><input type="radio" name="teoSocial[right]" value="1"  <?php if($right){echo "CHECKED";} ?> /></td>
                                    <td width="470">Display buttons in the right side of the website
										
										<input type="text" name="teoSocial[teoShareWidth]"   style="width:40px;"  value="<?php echo $teoSocial['teoShareWidth']; ?>"  />px.
									
									</td>
                            </tr>
                            <tr><td><input type="radio" name="teoSocial[right]" value="0"  <?php if(!$right){echo "CHECKED";} ?> /></td>
                                    <td>Display buttons after each article
                                    </td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td><input type="hidden" name="action" value="update" />
                                                    <input type="hidden" name="page_options" value="teoSocial" />
                                    </td>
                            </tr>
                            <tr valign="top" style="background:#eee; border:1px solid efefef;">
                                <td colspan="2">What share buttons would you Like?</td>
                            </tr>
                            <tr>
                                    <td>
                                            <input type="checkbox" name="teoSocial[enYm]" value="teoSocial[enYm]"  <?php if($teoSocial['enYm']){echo "CHECKED";} ?> />
                                    </td>
                                    <td>Display Yahoo Messenger Button</td>

                            </tr>
                            <tr>
                                    <td>
                                            <input type="checkbox" name="teoSocial[enTw]" value="teoSocial[enTw]"  <?php if($teoSocial['enTw']){echo "CHECKED";} ?> />
                                    </td>
                                    <td>Display Tweet Button</td>

                            </tr>																			
                            <tr>
                                    <td>
                                            <input type="checkbox" name="teoSocial[enFo]" value="teoSocial[enFo]"  <?php if($teoSocial['enFo']){echo "CHECKED";} ?> />
                                    </td>
                                    <td>Display Follow Button. Twitter account:<input name="teoSocial[tw]" type="text" id="teoSocial[Tw]" value="<?php echo $tw; ?>" />.
                                    	Width:<input type="text" name="teoSocial[teoFollowWidth]"   style="width:40px;"  value="<?php echo $teoSocial['teoFollowWidth']; ?>"  />px.
                                    
                                        </td>

                            </tr>
                            <tr>
                                    <td>
                                            <input type="checkbox" name="teoSocial[enLi]" value="teoSocial[enLi]"  <?php if($teoSocial['enLi']){echo "CHECKED";} ?> />
                                    </td>
                                    <td>Display Like Button. Width:
									<input  style="width:40px;" type="text" name="teoSocial[enLiWidth]" value="<?php echo $teoSocial['enLiWidth']; ?>"  />px.</td>

                            </tr>
							
                            <tr>
                                    <td>
                                            <input type="checkbox" name="teoSocial[enGo]" value="teoSocial[enGo]"  <?php if($teoSocial['enGo']){echo "CHECKED";} ?> />
                                    </td>
                                    <td>Display Google+ Button</td>
                            </tr>

                            <tr valign="top" style="background:#eee; border:1px solid efefef;">
                                <td colspan="2"> Choose pages where you would like to display share buttons</td>
                            </tr>
                             <tr>
                                <td><input type="checkbox" name="teoSocial[onFrontPage]" value="teoSocial[onFrontPage]"
                                      <?php if($teoSocial['onFrontPage']){echo "CHECKED";} ?> />
                                </td>
                                <td>on Front Page</td>
                            </tr>
                            <tr>
                               <td><input type="checkbox" name="teoSocial[onPage]" value="teoSocial[onPage]"
                                      <?php if($teoSocial['onPage']){echo "CHECKED";} ?> />
                                </td>
                                <td>on Pages</td>
                            </tr>
                            <tr>
                               <td><input type="checkbox" name="teoSocial[onSingle]" value="teoSocial[onSingle]"
                                      <?php if($teoSocial['onSingle']){echo "CHECKED";} ?> />
                                </td>
                                <td>on Posts - Articles</td>
                            </tr>
                            <tr>
                               <td><input type="checkbox" name="teoSocial[onCategory]" value="teoSocial[onCategory]"
                                      <?php if($teoSocial['onCategory']){echo "CHECKED";} ?> />
                                </td>
                                <td>on Categories and Archives</td>
                            </tr>



                            <tr valign="top" style="background:#eee; border:1px solid efefef;">
                                <td colspan="2">Update settings</td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td>
                                            <p>
                                            <input type="submit" value="<?php _e('Save Changes') ?>" />
                                            </p>
                                    </td>

                            </tr>
                            <tr valign="top" style="background:#eee; border:1px solid efefef;">
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                     </td>
                </tr>
            </table>
    </form>
    <table >
        <tr >
            </tr>
            <tr >
                <td>Details and comments about this plugin, here: <a target="_blank" ref="http://www.goo.gl/pr5IG">http://www.goo.gl/pr5IG</a> </td>
                <td>
                    I strongly recommend these books:
                </td>
            </tr>
            <tr>

                    <td style="border:1px solid #eee">
                            <h2>Plugins you must have:</h2>
                            <br />Included are:
                            <br />3 Essential Plugins to Help Prevent a <b>Blog Disaster</b>
                            <br />4 Plugins to Make Your Site Run <b>Faster & Smarter </b>
                            <br />5 Free Plugins to <b>Track & Analyse Your Blog Statistics </b>
                            <br />5 Plugins to Boost Your <b>Social Media & Bookmarking</b> Efforts
                            <br />4 Easy Plugins to Maximize Your <b>Search Engine Optimization </b>
                            <br />4 Audio & Video Plugins to Increase Your Site's <b>Popularity </b>
                            <br />5 Simple Plugins to Easily <b>Share Your Photos </b>
                            <br />3 Additional Plugins to Help <b>Manage Your Site  </b>
                            <br /> <a target="_blank" href="http://www.amazon.com/gp/product/145289390X/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=145289390X">Details</a>
                    </td>
                    <td style="border:1px solid #eee">
                            <a target="_blank" href="http://www.amazon.com/gp/product/145289390X/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=145289390X"><img border="0" src="http://ws.assoc-amazon.com/widgets/q?_encoding=UTF8&Format=_SL160_&ASIN=145289390X&MarketPlace=US&ID=AsinImage&WS=1&tag=inromaorg-20&ServiceVersion=20070822" ></a><img src="http://www.assoc-amazon.com/e/ir?t=inromaorg-20&l=as2&o=1&a=145289390X" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />

                    </td>
            </tr>

            <tr>

                <td colspan="2">
                    <a href="http://www.amazon.com/gp/product/B0033LTC8E/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=B0033LTC8E"><img border="0" src="http://ws.assoc-amazon.com/widgets/q?_encoding=UTF8&Format=_SL160_&ASIN=B0033LTC8E&MarketPlace=US&ID=AsinImage&WS=1&tag=inromaorg-20&ServiceVersion=20070822" ></a><img src="http://www.assoc-amazon.com/e/ir?t=inromaorg-20&l=as2&o=1&a=B0033LTC8E" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
    <a href="http://www.amazon.com/gp/product/B0012MWGHK/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=B0012MWGHK"><img border="0" src="http://ws.assoc-amazon.com/widgets/q?_encoding=UTF8&Format=_SL160_&ASIN=B0012MWGHK&MarketPlace=US&ID=AsinImage&WS=1&tag=inromaorg-20&ServiceVersion=20070822" ></a><img src="http://www.assoc-amazon.com/e/ir?t=inromaorg-20&l=as2&o=1&a=B0012MWGHK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
    <a href="http://www.amazon.com/gp/product/0071508570/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0071508570"><img border="0" src="http://ws.assoc-amazon.com/widgets/q?_encoding=UTF8&Format=_SL160_&ASIN=0071508570&MarketPlace=US&ID=AsinImage&WS=1&tag=inromaorg-20&ServiceVersion=20070822" ></a><img src="http://www.assoc-amazon.com/e/ir?t=inromaorg-20&l=as2&o=1&a=0071508570" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
    <a href="http://www.amazon.com/gp/product/1447505964/ref=as_li_qf_sp_asin_il?ie=UTF8&tag=inromaorg-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=1447505964"><img border="0" src="http://ws.assoc-amazon.com/widgets/q?_encoding=UTF8&Format=_SL160_&ASIN=1447505964&MarketPlace=US&ID=AsinImage&WS=1&tag=inromaorg-20&ServiceVersion=20070822" ></a><img src="http://www.assoc-amazon.com/e/ir?t=inromaorg-20&l=as2&o=1&a=1447505964" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />




                </td>
            </tr>
    </table>
</div>
<?php
}



add_action('wp_head', 'writeCSS');
add_filter('the_content', 'teoSocial');


register_activation_hook(__FILE__,'teoSocialInstall');
register_deactivation_hook( __FILE__, 'teoSocialRemove' );


?>