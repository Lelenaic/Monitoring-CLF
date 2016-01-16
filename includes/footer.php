<?php
//<b>Version</b> 0.0.1 - Page générée en '.$fin-$debut.'secondes
function footer(){
    $fin=microtime(true);
    echo '<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 4.0.0
        </div>
        <strong>Copyright &copy; 2015-'.date('Y').' <a href="">CLF Studio</a>.</strong> Tous droits réservés.
    </footer>';
}