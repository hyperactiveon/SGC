<?php

    //UTILIZADO PARA SELECIONAR O MENU NO HOME PAGE
    $url = [];

    if(strrpos($_SERVER['REQUEST_URI'], "dashboard")>0) {
        $url = ["active","","",""];
    }
    else if(strrpos($_SERVER['REQUEST_URI'], "produto")>0) {
        $url = ["","active","",""];
    } 
    else if(strrpos($_SERVER['REQUEST_URI'], "pedido")>0) {
        $url = ["","","active",""];
    } 
    else if(strrpos($_SERVER['REQUEST_URI'], "usuarios")>0) {
        $url = ["","","","active"];
    }
    
?>

<div class="sidebar">
    <!--div class="quickmenu">
        <div class="quickmenu__cont">
            <div class="quickmenu__list">
            <div class="quickmenu__item active"><div class="fa fa-fw fa-home"></div></div>
            </div>
        </div>
    </div-->
    <div class="scrollable scrollbar-macosx">
        <div class="sidebar__cont">
            <div class="sidebar__menu">

                <!--div class="sidebar__title">MENUS</div-->
                <ul class="nav nav-menu">
                    <li class="<?php echo $url[0]; ?>"><a href="./dashboard">
                        <div class="nav-menu__ico"><i class="fa fa-fw fa-star"></i></div>
                        <div class="nav-menu__text"><span>Dashboard</span></div></a>
                    </li>
                    <li class="<?php echo $url[1]; ?>"><a href="./produtos">
                        <div class="nav-menu__ico"><i class="fa fa-fw fa-cube"></i></div>
                        <div class="nav-menu__text"><span>Produtos</span></div></a>
                    </li>
                    <li class="<?php echo $url[2]; ?>"><a href=".pedidos">
                        <div class="nav-menu__ico"><i class="fa fa-fw fa-truck"></i></div>
                        <div class="nav-menu__text"><span>Pedidos</span></div>
                        <div class="nav-menu__right"><i class="badge badge-default">2</i></div></a>
                    </li>
                    <li class="<?php echo $url[3]; ?>"><a href="./usuarios">
                        <div class="nav-menu__ico"><i class="fa fa-fw fa-user"></i></div>
                        <div class="nav-menu__text"><span>Usuários</span></div></a>
                    </li>
                </ul>
            
            </div>
        </div>
    </div>
</div>