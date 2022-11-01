<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu p-0" id="contentSidebar" style="position:fixed">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item" id="choose_cyclist">
                <div class="side-nav-link pb-0 pt-1 ps-1 pe-1 mb-1">
                    <?php $this->insert("../leftsidebar/choose_cyclist") ?>
                </div>
            </li>
            <li class="side-nav-item" id="slider">
                <div class="side-nav-link pb-0 pt-0 mb-1">
                    <?php $this->insert("../leftsidebar/slider") ?>
                </div>
            </li>
            <li class="side-nav-item">
                <div class="side-nav-link pe-2 ps-2 pt-0 pb-0 d-grid">
                    <?php $this->insert("../leftsidebar/multiVis") ?>
                </div>
            </li>
            <li class="side-nav-item" id="barChart">
                <div class="side-nav-link pe-2 ps-2 pt-0">
                    <?php $this->insert("../chartBar/html_barChart") ?>
                </div>
            </li>
        </ul>


        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->