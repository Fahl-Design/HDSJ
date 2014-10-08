<?php
define("SB_API","your sickbeard api key");
define("SB_IP","your sickbeard server ip");
$genre = '';

if ((SB_IP) AND (SB_API)) {
    class sbh
    {
        function banner($tvdbid)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sb_banner = "<img src='" . $sburl . "show.getbanner&tvdbid=" . $tvdbid . "' class='img-responsive'> ";
            return $sb_banner;
        }

        function banner_url($tvdbid)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sb_banner = $sburl . "show.getbanner&tvdbid=" . $tvdbid;
            return $sb_banner;
        }

        function poster($tvdbid)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sb_poster = "<img src='" . $sburl . "show.getposter&tvdbid=" . $tvdbid . "' class='img-responsive'> ";
            return $sb_poster;
        }

        function poster_url($tvdbid)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sb_poster = $sburl . "show.getposter&tvdbid=" . $tvdbid;
            return $sb_poster;
        }

        function showinfo($sb_show)
        {
            global $sbh;
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;
            $sbJSON = json_decode(file_get_contents($feed));

            echo '<strong>' . $sbJSON->{data}->{show_name} . '</strong><br>';
            echo '<strong>Status:</strong> ' . $sbJSON->{data}->{status} . '<br>';
            echo '<strong>Quality: </strong>' . $sbJSON->{data}->{quality} . '<br>';
            echo '<strong>Networkt: </strong>' . $sbJSON->{data}->{network} . '<br>';
            echo '<strong>Genre: </strong>';
            echo $sbh->genre2($sb_show);
            echo '<br>';


        }

        function genre($sb_show)
        {
            global $show;
            global $genre;

            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;
            $sbJSON = json_decode(file_get_contents($feed));

            foreach ($sbJSON->{data}->{'genre'} as $show) {

                return $show;

            }

        }

        function genre2($sb_show)
        {
            global $show;
            global $genre;

            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;

            $jsonArray = json_decode(file_get_contents($feed), true);
            if (array_key_exists('data', $jsonArray)) {


                foreach ($jsonArray['data']['genre'] as $genre) {
                    echo $genre . ' ';

                }

            } else {

                echo "mööp";
            }

        }

        function gettvid($sb_show)//Todo
        {
            //$sb_show = "The%20Night%20Shift";
            global $tvid;
            global $genre;

            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'sb.searchtvdb&name=' . $sb_show;
            $feed = $sburl . $sbqry;

            $jsonArray = json_decode(file_get_contents($feed), true);
            var_dump_pretty($jsonArray);
            $res = $jsonArray['data']['results'];

            if (array_key_exists('tvdbid', $res)) {
                foreach ($jsonArray['data']['results'] as $tvid) {
                    echo $tvid . ' ';
                }
            } else {

                echo "mööp";
            }

        }

        function network($sb_show)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;
            $sbJSON = json_decode(file_get_contents($feed));

            return $sbJSON->{data}->{network};

        }

        function title($sb_show)
        {
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;
            $sbJSON = json_decode(file_get_contents($feed));

            return $sbJSON->{data}->{show_name};

        }


        function showpopup($sb_show) // jquerry popup
        {
            global $sb;
            global $sbh;
            $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
            $sbqry = 'show&tvdbid=' . $sb_show;
            $feed = $sburl . $sbqry;
            $sbJSON = json_decode(file_get_contents($feed));
            /*
            echo '<strong>Titel:</strong> '.$sbJSON->{data}->{show_name} .'<br>';
            echo '<strong>Status:</strong> '.$sbJSON->{data}->{status} .'<br>';
            echo '<strong>Quality: </strong>'.$sbJSON->{data}->{quality} .'<br>';
            echo '<strong>Networkt: </strong>'.$sbJSON->{data}->{network} .'<br>';
            */
            echo '<div data-role="popup" id="' . $sb_show . '" data-overlay-theme="b" data-theme="b" data-corners="false">';
            echo '	<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>';
            echo '	<img class="popphoto" src="' . $sbh->url_poster($sb_show) . '" style="max-height:512px;" alt="' . $sbJSON->{data}->{show_name} . '">';
            echo '</div>';
        }
    }
}



class sb
{

    function history($sb_limit) // twitter bootstrap 3.0.2 portfolio-item
    {

        global $sbh;
        global $design;
        $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
        $sbqry = "history&limit=" . $sb_limit . "&type=downloaded";
        $feed = $sburl . $sbqry;
        $sbJSON = json_decode(file_get_contents($feed));

        foreach ($sbJSON->{data} as $show) {
             function portfolioitem($tvid, $ep, $seson)
			{
				global $sbh;
				echo '<div class="col-md-2 col-xs-4 portfolio-item ';
				echo $sbh->genre2($tvid) . '">';

				echo '<a class="popup" href="' . $sbh->poster_url($tvid) . '" title="' . $sbh->title($tvid) . '">';
				echo '<span class="project-hover">';

				echo '<span>';
				if ($ep and $seson) {
					if (strlen($ep) == 1) {
						$ep = "0" . $ep;
					}
					if (strlen($seson) == 1) {
						$seson = "0" . $seson;
					}

					echo '<strong>S' . $seson . 'E' . $ep . '</strong><br><br>';
				}
				echo $sbh->showinfo($tvid);
				echo '</span>';
				echo '</span>';
				echo '<img src="' . $sbh->poster_url($tvid) . '" alt="portfolio-thumb-1">';
				echo '</a>';
				echo '</div>';
				echo("\n");
			}
        }
    }

    function showlist() // twitter bootstrap 3.0.2 portfolio-item
    {

        global $design;
        $sburl = 'http://' . SB_IP . '/api/' . SB_API . '/?cmd=';
        $sbqry = "shows";
        $feed = $sburl . $sbqry;
        $sbJSON = json_decode(file_get_contents($feed));

        foreach ($sbJSON->{data} as $show) {
            function portfolioitem($tvid, $ep, $seson)
			{
				global $sbh;
				echo '<div class="col-md-2 col-xs-4 portfolio-item ';
				echo $sbh->genre2($tvid) . '">';

				echo '<a class="popup" href="' . $sbh->poster_url($tvid) . '" title="' . $sbh->title($tvid) . '">';
				echo '<span class="project-hover">';

				echo '<span>';
				if ($ep and $seson) {
					if (strlen($ep) == 1) {
						$ep = "0" . $ep;
					}
					if (strlen($seson) == 1) {
						$seson = "0" . $seson;
					}

					echo '<strong>S' . $seson . 'E' . $ep . '</strong><br><br>';
				}
				echo $sbh->showinfo($tvid);
				echo '</span>';
				echo '</span>';
				echo '<img src="' . $sbh->poster_url($tvid) . '" alt="portfolio-thumb-1">';
				echo '</a>';
				echo '</div>';
				echo("\n");
			}
        }
    }
}

?>