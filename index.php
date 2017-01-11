<html>
    
        <title>Mijn filebrowser</title>
        <link rel="stylesheet" type="text/css" href="filebrowser.css">
    <div id="kader4">

        <?php
        echo '<div id="bestandinfo"><h2>Inhoud</h2>';

        //Controleren welk bestand is aangeklikt.
        $bestand = getcwd();
        if (isset($_GET['bestand'])) {
            $bestand = $_GET['bestand'];
            //echo $bestand;
            echo "Bestand: " . $bestand . '<br />';
        } else {
            echo 'Bestand: ' . "Er is nog geen bestand aangeklikt." . '<br />';
        }

        //Checkt hoe groot het bestand is.
        if (isset($_GET['bestand'])) {
            $bestandsnaam = $_GET['map'] . $_GET['bestand'];
            echo 'Grootte: ' . human_filesize(filesize($bestandsnaam)) . '<br />';
        } else {
            echo 'Grootte: ' . 'Kan de grootte nog niet berekenen.' . '<br>';
        }

        function human_filesize($bytes, $decimals = 2) {
            $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
        }

        //kijkt of het $bestand schrijfbaar is.
        if (is_writable($bestand)) {
            echo ("Schrijfbaar: Ja" . '<br />');
        } else {
            echo ("Schrijfbaar: Nee" . '<br />');
        }

        // echoed laatst aangepast.
        setlocale(LC_ALL, 'nl_NL');
        echo "Laatst aangepast: " . date("d F Y - H:i:s.", getlastmod());

        echo '</div>';
        ?>

    </div>

    <div id="kader1">
        <?php
        $map = getcwd();

        //echo $map;
        //print_r($_GET);
        if (isset($_GET['map'])) {
            $map = $_GET['map'];
            $map = realpath($map) . "/";
        } else {
            $map = getcwd() . "/";
        }

        //Om puntjes uit de URL te filteren:
        $objecten = realpath($map);

        $objecten = scandir($map);

        echo "<pre>";

        echo "</pre>";

        echo '<h1><a href="index.php">Mappen/Bestanden</a></h1>';

        foreach ($objecten as $object) {

            if (is_file($map . $object)) {
                echo 'D: <a href="index.php?map=' . $map . '&amp;bestand=' . $object . '">' . $object . "</a><br />";
            }

            //punt verwijderen uit bestandsinhoud:
            elseif ($object == "." || $object == ".." && $map == 'C:\xampp\htdocs\Filebrowser/') {
                
            } else {
                echo 'F: <a href="index.php?map=' . $map . $object . '/">' . $object . "</a><br />";
            }
        }
        ?></div>

    <div id="kader2">
        <?php
        if (isset($_GET['bestand'])) {
            $bestandsnaam = $_GET['map'] . $_GET['bestand'];
            $opslaan = $_GET['bestand'];
            //C: schijf/xampp/htdocs... verwijderen.
            $bestandsnaam = str_replace(getcwd() . "\\", "", $bestandsnaam);

            $bestandext = pathinfo($bestandsnaam . "", PATHINFO_EXTENSION);

            if ($bestandext == "jpg" || $bestandext == "png" || $bestandext == "gif") {
                echo '<img src="' . $bestandsnaam . '" width="200" height="200" >';
            }

            if ($bestandext == "php" || $bestandext == "css" || $bestandext == "txt") {
                if (isset($_POST ["ash"])) {
                    file_put_contents($bestandsnaam, ($_POST['ash']));
                }
                $inhoudbestand = file_get_contents($bestandsnaam);
                echo '<form method="post" action="index.php?map=' . $_GET['map'] . '&amp;bestand=' . $opslaan . '">';
                echo "<input id='Save' type='submit' value='Save'>";
                echo "<textarea name='ash' rows='20' cols='119'>";
                echo htmlentities($inhoudbestand);
                echo "</textarea>";
                echo '</form>';
            }
        }
        ?></div>

    <div id="kader3"><h1><a href="index.php">Home ></a></h1></div>
</html>
