<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <main class="app-main py-3">
                <?php $this->load->view($content_view, isset($view_data) ? $view_data : array()); ?>
            </main>
        </div>
    </div>
