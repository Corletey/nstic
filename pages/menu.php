<ul class="navbar-nav nav lavalamp ml-auto menu">
       <li class="nav-item"><a href="./" class="nav-link active"><?php echo $lang_home; ?></a> </li>

       <?php
        $sql_menu = "SELECT * FROM " . $prefix . "pages where section='menu' order by rank asc limit 0,5";
        $sqlF_menu = $mysqli->query($sql_menu);
        while ($rs_menu = $sqlF_menu->fetch_array()) {
        ?>
           <li class="nav-item"><a href="./details.php?gr=<?php echo $rs_menu['id']; ?>" class="nav-link"><?php echo $rs_menu['title']; ?></a></li>
       <?php } ?>
       <li class="nav-item"><a href="./all-grants.php" class="nav-link">Grants</a></li>
       <li class="nav-item"><a href="./awarded-grants.php" class="nav-link">Awarded Grants</a></li>
       


       <li class="nav-item"><a href="#" class="nav-link active"><?php echo $lang_chooselanguage; ?> <i class="arrow down"></i></a>


           <ul class="navbar-nav nav mx-auto">
               <li class="nav-item"><a href="./index.php?lang=en" class="nav-link" <?php if ($base_lang == 'en') { ?>style="color:#F00!important;" <?php } ?>>English</a></li>
               <li class="nav-item"><a href="./index.php?lang=fr" class="nav-link" <?php if ($base_lang == 'fr') { ?>style="color:#F00!important;" <?php } ?>>French</a></li>
               <li class="nav-item"><a href="./index.php?lang=pt" class="nav-link" <?php if ($base_lang == 'pt') { ?>style="color:#F00!important;" <?php } ?>>Portuguese</a></li>

           </ul>
       </li>
   </ul>