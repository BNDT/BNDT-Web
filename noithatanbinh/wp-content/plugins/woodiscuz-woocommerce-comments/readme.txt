=== WooDiscuz - WooCommerce Comments ===

Contributors: gVectors Team
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JD86QPWM6QUXW
Tags: WooCommerce, WooCommerce Comments, WooCommerce Reviews, WooCommerce Product Discussions, comments, reviews, discussions, product, shop, ecommerce, comments tab, discussion tab, question and answer, product question, product support
Requires at least: 3.0
Tested up to: 4.5.0
Stable tag: 2.0.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WooCommerce comments and discussion Tab. Allows your customers discuss about your products, vote for comments and share. 

== Description ==

WooCommerce product comments and discussion Tab. Allows your customers to discuss about your products and ask pre-sale questions. Adds a new "Discussions" Tab next to "Reviews" Tab. Your shop visitors will thank you for ability to discuss about your products directly on your website product page. WooDiscuz also allows to vote for comments and share products.

**WooDiscuz helps you increase your sales!**

- *It gives life to your online store ;)*
- *Keeps customers closer to your shop*
- *Lets them discuss about your products*
- *Allows to ask pre-sale questions before buying the product*
- *Lets your shop visitors see all customers' activity*
- *Allows you to provide an excellent customer support on product page*
- *As a result you have a ready and product specific FAQ under each Product separately*

**WooDiscuz Features:**

* | **Front-end**
* | Adds a new "Discussions" Tab on product page
* | Responsive discussion form and comment threads design
* | Interactive, clean, simple and easy user interface and user experience
* | Fast and easy comment form with ajax validation and data submitting 
* | Allows to create a new discussion thread and reply to existing comment
* | Ajax button "Load More Comments" instead of simple comments pagination
* | Fully integrated and compatible with Wordpress and WooCommerce 
* | Uses Wordpress Comment system with all managing functions and features
* | Flexible options for Guests, Customers and Administrators permissions
* | Adds labels/titles for each discussion member ( Guest, Customer, Support )
* | Uses WP Avatar System, fully compatible with BuddyPress and other profiling plugins
* | Secure and Anti-Spam features will not allow spammers to comment
* | Comment voting with positive and negative result
* | Smart voting system with tracking by logged-in user and cookies
* | Product sharing options: Facebook, Twitter and Google+
* | Recent Comments Widget
* | Recent Reviews Widget (WooCommerce one doesn't filter WooDiscuz comments)
* | Users can edit their comments (time-frame can be limited by admin)
* | Users can Subscribe/Unsubscribe to new comments
* 
* | **Dashboard** 
* | Option to set Discussion Tab as the first opened Tab on product page 
* | Option to hide/remove WooCommerce Product Review Tab
* | Options to turn On/Off Comment Voting and Product Sharing features
* | Option to hide/show CAPTCHA field on comment form
* | Option for "User Must be registered to comment"
* | Option to held new comments for moderation 
* | Option to hide "Reply" button for Guests, allowing only to create a new threads
* | Option to hide "Reply" button for Customers, allowing only to create a new threads
* | Option to hide user labels/titles
* | Option to set usergroups for "Support" user label/title 
* | Option to set number of comment threads per page (for "load more comments" button) 
* | Option to notify administrators and comment authors on new comment/reply
* | Option to manage font color and comment/reply background colors
* | Option to set WooDiscuz tab (discussion) priority
* | Option to redirect first commenters to "Thank You" page 
* | Front-end phrase managing options, you'll be able to translate or change all phrases

[youtube https://www.youtube.com/watch?v=umtFm20haRA /]


If your Wordpress is not 4.x please read the note below.

**IMPORTANT NOTE:** This plugin is designed for Wordpress 4.0 and higher versions. If your Wordpress version is less than 4.0, you should do a small change in `wp-includes/comment-template.php` file.

Please open it and find this:

`$r = wp_parse_args( $args, $defaults );`

Add this row after:

`$r = apply_filters( 'wp_list_comments_args', $r );`

There will not be any additional changes on Wordpress update. If you update your Wordpress to 4.x this script will be added automatically.


== Installation ==

1. Upload plugin folder to the '/wp-content/plugins/' directory,
2. Activate the plugin through the 'Plugins' menu in WordPress.

If your Wordpress is not 4.x please read the note below.

**IMPORTANT NOTE:** This plugin is designed for Wordpress 4.0 and higher versions. If your Wordpress version is less than 4.0, you should do a small change in `wp-includes/comment-template.php` file.

Please open it and find this:

`$r = wp_parse_args( $args, $defaults );`

Add this row after:

`$r = apply_filters( 'wp_list_comments_args', $r );`

There will not be any additional changes on Wordpress update. If you update your Wordpress to 4.x this script will be added automatically.

== Frequently Asked Questions ==

= Please Check the Following WooDiscuz Resources =

* Support Forum: <http://gvectors.com/questions/>
* Plugin Page: http://www.gvectors.com/woodiscuz-woocommerce-comments-and-product-discussions/
* WooDiscuz Global Community: http://woodiscuz.com/
* Blog: http://profprojects.com/category/blog/woocommerce/

== Screenshots ==

1. Ajax Form to add a new discussion thread Screenshot #1
2. Discussion Threads with Reply Form Screenshot #2
3. Full Front-End View Screenshot #3
4. WooDiscuz General Settings #4
5. WooDiscuz Comment Management Page Screenshot #5
6. WooDiscuz Front-end Phrase Manager #6
7. Another Full Front-End View Screenshot #7

== Changelog ==

= 2.0.10 =

* Fixed Bug: Email notification issue when reply made from Dashboard > Comments admin page

= 2.0.9 =

* Fixed Bug: Problem with email JS validation
* Fixed Bug: Problem with email notification
* Fixed Bug: Problem with translation .po/.mo files

= 2.0.8 = 

* Fixed Bug : Comments are not displayed after the latest update

= 2.0.7 = 

* Fixed Bug : Comments are not displayed
* Fixed Bug : Review pagination conflict

= 2.0.6 = 

* Changed : Option comments per page moved to default Wordpress Discussions settings
* Changed : Option comment depth moved to default Wordpress Discussions settings
* Changed : Option comment ordering moved to default Wordpress Discussions settings
* Fixed Bug : Comment ordering issue

= 2.0.5 = 

* Added : WooDiscuz subscription functions integrated with WooCommerce Email Settings

= 2.0.4 =
 
* Fixed Bug : Access to undeclared static property
* Added : GlotPress translation support

= 2.0.3 = 

* Added : Swedish translation (sv_SE), thanks to Patrik [DataNovisen.se} 
* Fixed Bug : Comment subscription email sending issue

= 2.0.2 = 

* Added : Adapting with wordpress.org plugin repository guidelines
* Added : Polish translation (pl_PL), thanks to Michal Czyz

= 2.0.1 =

* Added : Language translation support with .mo and .po files

= 2.0.0 =

* Added : Recent Comments Widget
* Added : Recent Reviews Widget (WooCommerce one doesn't filter WooDiscuz comments)
* Added : Additional phrases for plural form
* Added : Tabbed General Settings admin page
* Added : Option to set WooDiscuz tab (discussion) priority
* Added : Tabbed Phrase Manager admin page
* Added : Users can Subscribe/Unsubscribe to new comments
* Added : Option to allow guests vote for comments
* Added : VK.com and OK.ru social network share buttons
* Added : Automatic URLs to link conversion in comment texts
* Added : Option to redirect first commenters to "Thank You" page 
* Added : Language translation support with .mo and .po files
* Added : Close pop-up messages by clicking outside of message-box
* Added : Users can edit their comments (time-frame can be limited by admin)
* Added: Option to enable .po/.mo translation files for mult-language sites
* Fixed Bug: Header CSS code for dynamic style values ( 90% reduced )
* Fixed Bug: JavaScript and CSS conflicts with wpDiscuz
* Fixed Bug: Limited maximum characters for phrases


= 1.1.6 =

* Fixed Bug: Adapted with some themes ( Fatal error: Cannot redeclare add_user() )
* Fixed Bug: Incorrect comment date/time if the default Wordpress date format is on

= 1.1.5 =

* Added : Language translation support with .mo and .po files
* Added : Different comment date formats, reflects WordPress date format settings
* Added : Ability to insert image in comment content using image source URL
* Added : URLs to link auto-conversion in comment texts
* Added : Option to set nested comments maximum depth level
* Fixed Bug: Problem with large space between the paragraphs

= 1.1.4 =

* Fixed Bug: Problem with phrase saving.

= 1.1.3 =

* Added : Option to keep comment threads private for product author and thread starter. This option will not allow users reply in other users' threads, however those will be readable for all.
* Added : Option to sort comments by comment date with ascending or descending order
* Fixed Bug: Problem with popup window [close] button.

= 1.1.2 =

* Added : Option to set comment text font size
* Added : Option to set form background color
* Added : Better responsively on mobile devices
* Added : better CAPTCHA image with colors and lines
* Fixed Bug: Undefined loader spinner image source.

= 1.1.1 =

* Fixed Bug : Layout and Style Issues

= 1.0.9 =

* Added : Comment author names are links to their profile page (BuddyPress, Users Ultra)
* Fixed Bug : CSS Issues

= 1.0.8 =

* Fixed Bug : Problem with options page redirection on Wordpress multi-sites

= 1.0.7 =

* Added : Comment author names are link to their profile page (BuddyPress).
* Added : Sends email to customer after purchase with a request to comment on the product page.

= 1.0.6 =

* Added : Number of comments on the Discussion Tub next to the title.
* Fixed Bug : Shorter view of comment date displaying
* Fixed Bug : Pop-up box conflict with theme JavaScript. Changed to CSS only.

= 1.0.5 =

* Fixed Bug : Pop-up box appears and the loading continues for the infinite time on posting a new comment

= 1.0.4 =

* Fixed Bug : Maximum execution time error on inserting a new comment.
* Fixed Bug : Encoding issue with non-latin characters

= 1.0.3 =

* Fixed Bug : Gravatars issue in product reviews
* Fixed Bug : WooDiscuz comments' time zones synchronization with Wordpress
* Fixed Bug : Header text changing issue

= 1.0.2 =

Fixed Bug : CAPTCHA reloading issue with wp-content redirecting plugins.

= 1.0.1 =

Fixed Bug : All comment replies from Dashboard > Comments went to Product Review. Now it's being filtered and added in right place.

= 1.0.0 =

Initial version
