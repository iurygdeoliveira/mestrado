<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu p-0">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav" style="z-index: 1">
            <li class="side-nav-item">
                <div class="side-nav-link pb-0">
                    <?php $this->insert("../leftsidebar/selectRider") ?>
                </div>
            </li>

            <li class="side-nav-item">
                <div class="side-nav-link pb-0 pt-0">
                    <?php $this->insert("../leftsidebar/defineDistance") ?>
                </div>
            </li>

            <li class="side-nav-item">
                <div class="side-nav-link pe-3 ps-3">
                    <?php $this->insert("../leftsidebar/selected") ?>
                </div>
            </li>
            <li class="side-nav-item">
                <div class="side-nav-link pt-0 pb-0">
                    <?php $this->insert("../leftsidebar/updateButtonCreateVis") ?>
                </div>
            </li>
        </ul>


        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->