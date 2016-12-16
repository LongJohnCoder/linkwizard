function  fb_share(short_url , from_url)
{
    //alert('in fb_share');
    //alert(path);
    
        FB.init({
        appId      : '349677008739634',
        xfbml      : true,
        version    : 'v2.7',
        status     : true,
        cookie     : true
        });
        FB.ui(
        {
            method: 'share',
            description: 'Want to make your links user friendly? We manage to shorten all your URLs and provide hastle free services. Feel free to check our site http://www.tr5.io ',
            picture: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDls6NeGdKEsPOyOiDgtAQoVS-6YmZpXAhO-gHaMYH0QKXVHAo',
            href: from_url,
            link: short_url,
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