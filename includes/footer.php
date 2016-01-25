<?php
function footer(){
    $fin=microtime(true);
    echo '<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2015-'.date('Y').' <a href="">CLF Studio</a>.</strong> Tous droits réservés.
    </footer>';
}