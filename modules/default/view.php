<?php
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myDate = new Date();
$myBBCode = new BBCode();
$myCheck = new Check();

/***************************/
/* check data			   */
/***************************/
//$myCheck->checkURL("forum_thread", "id", $_GET["id"]);

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])) {${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["added"];

foreach($postData as $value){
    if(isset($_POST[$value])) {
        ${$value} = $_POST[$value];
    }else{
        ${$value} = null;
    } 
}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_thread",
[
"[><]forum" => ["forum_thread.forum_id" => "id"],
"[><]forum_post" => ["forum_thread.id" => "forum_thread_id"],
"[><]account" => ["account_id" => "id"],
"[><]account_information" => ["account.account_information_id" => "id"],
"[><]account_settings" => ["account.account_settings_id" => "id"],
],[
"forum_thread.id",
"forum_thread.forum_id",
"forum_post.title",
"forum.title(forumTitle)",
"forum_post.created",
"forum_post.content",
"forum_thread.image",
"account_information.firstname",
"account_information.lastname",
"account_information.phoneNumber"
],[
"AND" =>["forum_thread.id" => $id, "forum_post.creator" => "1"]]);

//var_dump($database->error());

/***************************/
/* output                  */
/***************************/
foreach($query as $output){ ?>

<!-- section2 -->
<div class="styleLight">
	<div class="content">

        <!-- header -->
        <header>
            <div class="col-full">
                <div class="wrap-col">
                    <h2><?php echo $output["title"]; ?></h2>
                </div>
            </div>
        </header>
        
        <div class="col-3-12 col-3-12m col-5-12sm">
            <div class="wrap-col">				
                <!-- Section 1 picture -->
                <figure class="imageFeed">
                    <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/uploads/<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="<?php echo $output["title"]?>">
                </figure>
            </div>
        </div>

        <!-- share button -->
        <div class="col-9-12 col-9-12m col-7-12sm shareButton">
                    <div class="wrap-col">

                        <?php $sharebtn_array = [
                                [
                                    "name" => "Facebook", 
                                    "image" => "/res/images/social/circle_social_facebook.svg", "link" => "https://www.facebook.com/sharer/sharer.php?u=http://89.160.115.26/pages/product/view.php?id=".$id."&title=".$output["title"]."&image=http://89.160.115.26/res/uploads/topic/".$output["image"].""],
                                [
                                    "name" => "Twitter",
                                    "image" => "/res/images/social/circle_social_twitter.svg",
                                    "link" => ""
                                ],
                                [
                                    "name" => "LinkedIn",
                                    "image" => "/res/images/social/circle_social_linkedin.svg",
                                    "link" => ""
                                ],
                                [
                                    "name" => "Instagram",
                                    "image" => "/res/images/social/circle_social_instagram.svg",
                                    "link" => ""
                                ],
                                [
                                    "name" => "Youtube",
                                    "image" => "/res/images/social/circle_social_youtube.svg",
                                    "link" => ""
                                ]

                            ];
                        
                        foreach($sharebtn_array as $shareOutput ){ ?>

                            <div class="col-1-12 col-2-12m col-4-12sm">
                                <div class="wrap-col">

                                    <a href="<?php echo $shareOutput["link"]; ?>" title="<?php echo $shareOutput["name"]; ?>" target="_blank">
                                        <img src="<?php echo $shareOutput["image"]; ?>">
                                    </a>

                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
                                
		<!-- information -->
		<div class="col-9-12 col-9-12m">
			<div class="wrap-col">

				<p>
                    <?php echo $myBBCode->useBBCode($output["content"]); ?>
                </p>

                <p>
                    <span>
                        <?php echo $myDate->rewriteDate("%A %d %B %Y", $output["created"]); ?>
                    </span>
                </p>

			</div>
		</div>

	</div>
</div>

<?php } require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>