function  fb_share(app_id, short_url , from_url, fb_description, fb_title, fb_image, fb_url)
{
    //alert('in fb_share');
    //alert(path);

        FB.init({
        appId      : app_id,
        xfbml      : true,
        version    : 'v2.7',
        status     : true,
        cookie     : true
        });
        FB.ui(
        {
            method      : 'share',
            description : fb_description,
            title       : fb_title,
            picture     : fb_image,
            href        : short_url,
            link        : fb_url,
        },
        function(response)
        {
            console.log("FB Response: "+typeof(response));
            if(typeof(response) !== "undefined" && typeof(response) !== undefined && response)
            {

            }
            else
            {

            }
        });

}
