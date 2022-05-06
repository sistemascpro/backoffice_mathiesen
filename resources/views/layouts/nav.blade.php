<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <a href="/"><img src="<?=$DatosGen['NombreEmpresa'][0]->logo3?>?<?=date("YmdHis")?>" class="logo-icon" alt="logo icon"></a>
                </div>
                <div>
                    <h4 class="logo-text"><?=$DatosGen['NombreEmpresa'][0]->nombre?></h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <?php
                    for($i=0; $i<count(session('permisos')); $i++)
                    {
                        if(session('permisos')[$i]->url=='#')
                        {
                            ?>
                            <li>
                                <a href="javascript:;" class="has-arrow">
                                    <div class="parent-icon"><?=session('permisos')[$i]->icono?></i></div>
                                    <div class="menu-title"><?=session('permisos')[$i]->nombre?></div>
                                </a>
                                <ul>
                                    <?php
                                        for($x=0; $x<count(session('permisos')); $x++)
                                        {
                                            if(session('permisos')[$i]->id==session('permisos')[$x]->padre)
                                            {
                                                ?><li><a href="<?=session('permisos')[$x]->url?>"><?=session('permisos')[$x]->nombre?></a></li><?php
                                            }
                                        }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                    }
                ?>
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
