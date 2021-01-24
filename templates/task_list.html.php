<?php

/**
 * task list template
 */

$title = 'Список задач' ?>

<?php ob_start();

foreach ($tasks as $task) { ?>
    <ul class="uk-list uk-list-striped">
        <li>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <?php if ($is_admin) { ?>
                    <label><input class="uk-checkbox" type="checkbox" checked>
                        <span><?= $task['body'] ?></span>
                        <?php switch ($task['state']) {
                            case 'New':
                                echo "<span class=\"uk-label uk-label-success\">New</span>";
                                break;
                            case 'Complete':
                                echo "<span class=\"uk-label uk-label-success\">Complete</span>";
                                break;
                            case 'Pending':
                                echo "<span class=\"uk-label uk-label-success\">In progress</span>";
                                break;
                        } ?>
                    </label>

                <?php } else { ?>
                <?php } ?>
            </div>
        </li>
    </ul>
<?php }
$content = ob_get_clean() ?>

<?php include 'index.html.php' ?>