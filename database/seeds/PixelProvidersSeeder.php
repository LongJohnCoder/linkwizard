<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class PixelProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pixel_providers')->insert([
            [
                'provider_name'=> 'Facebook',
                'provider_code'=> 'FB',
                'script'=> '<script> !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n; n.push=n;n.loaded=!0;n.version=\'2.0\';n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,\'script\',\'https://connect.facebook.net/en_US/fbevents.js\'); // Insert Your Facebook Pixel ID below.  fbq(\'init\', \'FB_PIXEL_ID\'); fbq(\'track\', \'PageView\'); </script> <!-- Insert Your Facebook Pixel ID below. -->  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=FB_PIXEL_ID&amp;ev=PageView&amp;noscript=1" /></noscript>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'provider_name'=> 'Google',
                'provider_code'=> 'GL',
                'script'=> '<script> (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');  ga(\'create\', \'GL_PIXEL_ID\', \'auto\'); ga(\'send\', \'event\', \'category\', \'action\', \'label\'); </script>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'provider_name'=> 'LinkedIn',
                'provider_code'=> 'LI',
                'script'=> '<script type="text/javascript"> _linkedin_data_partner_id = "LI_PIXEL_ID"; </script><script type="text/javascript"> (function(){var s = document.getElementsByTagName("script")[0]; var b = document.createElement("script"); b.type = "text/javascript"; b.async = true; b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js"; s.parentNode.insertBefore(b, s);})(); </script> <noscript> <img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=LI_PIXEL_ID&fmt=gif" /> </noscript>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'provider_name'=> 'Twitter',
                'provider_code'=> 'TWT',
                'script'=> '<script src="//platform.twitter.com/oct.js" type="text/javascript">  </script>   <script type="text/javascript"> twttr.conversion.trackPid(\'TWT_PIXEL_ID\', {tw_sale_amount: 0, tw_order_quantity: 0 }); </script>  <noscript>  <img height="1" width="1" style="display:none;" alt=" " src="https://analytics.twitter.com/i/adsct?txn_id=TWT_PIXEL_ID&p_id=Twitter$tw_sale_amount=0&tw_order_quantity=0" /> <img height="1" width="1" style="display:none;" alt=" " src="//t.co/i/adsct?txn_id=TWT_PIXEL_ID&p_id=Twitter$tw_sale_amount=0&tw_order_quantity=0" />   </noscript>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'provider_name'=> 'Pintrest',
                'provider_code'=> 'PN',
                'script'=> '<script type="text/javascript">!function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version="3.0";var t=document.createElement("script");t.async=!0,t.src=e;var r=document.getElementsByTagName("script")[0];r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js"); pintrk(\'load\', \'YOUR_TAG_ID\'​); pintrk(\'page\'); </script> <noscript> <img height="1" width="1" style="display:none;" alt="" src="https://ct.pinterest.com/v3/?tid=YOUR_TAG_ID&noscript=1" /> </noscript>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'provider_name'=> 'Custom',
                'provider_code'=> 'CS',
                'script'=> '<script type="text/javascript"></script> <noscript> <img height="1" width="1" style="display:none;" alt="" src="https://ct.pinterest.com/v3/?tid=YOUR_TAG_ID&noscript=1" /> </noscript>',
                'is_active'=> '1',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ]
        ]);    
    }
}
