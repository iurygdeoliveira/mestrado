<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item">
                <a href="<?= url() ?>" class="side-nav-link">
                    <span> 3 - Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a class="side-nav-link">
                    <span onmouseover="getData('analiseAjax')" onclick="renderData('analiseAjax')"> 2 - Análise Exploratoria </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="<?= url('/popular') ?>" class="side-nav-link">
                    <span> 1 - Popular BD </span>
                </a>
            </li>

        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->