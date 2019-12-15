<?php
class PaginationView
{
    private $itemsPerPage;
    private $currentPage;
    private $totalItems;
    private $totalPages;
    private $controllerName;
    private $url;

    function __construct($itemsPerPage, $currentPage, $totalItems, $controllerName, $url=NULL)
    {
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalItems = $totalItems;
        $this->totalPages = ceil($totalItems / $itemsPerPage);
        $this->controllerName = $controllerName;
        if ($controllerName === "Schedule") {
            $this->url = $url;
        } else {
            $this->url = "../Controllers/" . $controllerName . "Controller.php?";
        }
        $this->render();
    }

    function render()
    {
        ?>
        <div class="row">

            <?php if ($this->totalItems > 0): ?>
                <!-- Search -->
                <a class="btn btn-primary button-specific-search" role="button"
                   href="<?php echo $this->url ?>action=search">
                    <span data-feather="search"></span>
                    <p class="btn-show-view" data-translate="Búsqueda específica"></p>
                </a>

                <!-- Pagination -->
                <label class="label-pagination" data-translate="Items por página"></label>
                <select class="form-control items-page" id="items-page-select"
                        onchange="selectChange(this, '<?php echo $this->controllerName ?>')">
                    <option value="5" <?php if ($this->itemsPerPage == 5) echo "selected" ?>>5</option>
                    <option value="10" <?php if ($this->itemsPerPage == 10) echo "selected" ?>>10</option>
                    <option value="15" <?php if ($this->itemsPerPage == 15) echo "selected" ?>>15</option>
                    <option value="20" <?php if ($this->itemsPerPage == 20) echo "selected" ?>>20</option>
                </select>
                <?php if ($this->totalPages > 1): ?>
                    <nav aria-label="...">
                        <ul class="pagination">
                            <?php if ($this->currentPage == 1): ?>
                        <li class="page-item disabled">
                        <?php else: ?>
                            <li class="page-item">
                                <?php endif; ?>
                                <a class="page-link"
                                   href="<?php echo $this->url ?>currentPage=<?php echo $this->currentPage - 1 ?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $this->totalPages; $i++): ?>
                                <?php if ($this->currentPage == $i): ?>
                                    <li class="page-item active">
                                <?php else: ?>
                                    <li class="page-item">
                                <?php endif; ?>
                                <a class="page-link"
                                   href="<?php echo $this->url ?>currentPage=<?php echo $i ?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                    <?php echo $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($this->currentPage == $this->totalPages): ?>
                            <li class="page-item disabled">
                                <?php else: ?>
                            <li class="page-item">
                                <?php endif; ?>
                                <a class="page-link"
                                   href="<?php echo $this->url ?>currentPage=<?php echo $this->currentPage + 1 ?>&itemsPerPage=<?php echo $this->itemsPerPage ?>">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
<?php
    }
}
?>