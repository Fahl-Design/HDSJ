 <?php
 // Define your prefered hoster: so (Share-Online) ul (uploaded) 
 define("SJ_HOSTER", "so");
 // Set up the url and episode title
$url = "http://serienjunkies.org/murder-in-the-first/murder-in-the-first-staffel-1-hdtvweb-dl-sd720p1080p/"; 
$title = "Murder.in.the.First.S01E01.Mord.in.Tenderloin.German.Dubbed.DL.iTunesHD.x264-TVS";
 
 
function urlcheck($url) {

    $chc =  substr($url, -1);
    if ($chc == "/") {
        $url = substr($url, 0, -1);
        return $url;
    }else{
        return $url;
    }
 }
 
 function sj_urlrewirte($url, $title)
    {
		$urlcheck($url);
        echo $url;
        if (!is_null($url) AND !is_null($title)) {
            $html = file_get_contents($url);
            $doc = new DOMDocument();
            $doc->strictErrorChecking = false;
            $doc->recover = true;
            @$doc->loadHTML("<html><body>" . $html . "</body></html>");
            $xpath = new DOMXPath($doc);

            $nodqry = ".//*[@id='content']/div/div/p[contains(.,'" . $title . "')]/a/@href[contains(.,'".SJ_HOSTER."_')]";


            $elements = $xpath->query($nodqry);


            if ($elements) {
                return $elements->item(0)->nodeValue;
            } else {
                return "ERROR";
            }


        } elseif (is_null($url) AND !is_null($title)) {
            return "ERROR URL not set ";
        } elseif (is_null($title) AND !is_null($title)) {
            return "ERROR Title not set ";
        } elseif (is_null($url) AND is_null($title)) {
            return "ERROR URL and Title not set ";

        }
    }
}



echo $sj_urlrewirte($url,$title);