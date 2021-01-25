<?php

/**
 * task list template
 */

$title = 'Список задач' ?>

<?php ob_start(); ?>

    <section class="uk-section">
        <div class="uk-container">
            <div class="uk-float-right header__actions">
                <a class="uk-button uk-button-primary" href="#task-section" uk-toggle>Добавить</a>
                <?php if (isset($_SESSION['username'])) { ?>
                    <a class="uk-button uk-button-default" href="index.php?auth=logout" uk-toggle>Logout</a>
                <?php } else { ?>
                    <a class="uk-button uk-button-default" href="#login-section" uk-toggle>Login</a>
                <?php } ?>

                <div id="task-section" uk-modal>
                    <div class="uk-modal-dialog">
                        <form action="index.php?task=create" method="post">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <div class="uk-modal-header">
                                <h2 class="uk-modal-title">Add task</h2>
                            </div>
                            <div class="uk-modal-body">
                                <div class="uk-margin">
                                <textarea id="body"
                                          class="uk-textarea uk-child-width"
                                          rows="5"
                                          name="body"
                                          placeholder="Task body"></textarea>
                                    <p></p>
                                    <?php if ($is_admin) { ?>
                                        <select id="user"
                                                class="uk-select"
                                                name="user">
                                            <option selected value="1">
                                                Admin
                                            </option>
                                            <option disabled value="2">
                                                Ivan
                                            </option>
                                            <option disabled value="3">
                                                Mary
                                            </option>
                                        </select>
                                        <p></p>
                                        <select id="state"
                                                class="uk-select"
                                                name="state">
                                            <option selected value="new">
                                                New
                                            </option>
                                            <option value="pending">
                                                Pending
                                            </option>
                                            <option value="done">
                                                done
                                            </option>
                                        </select>
                                    <?php } else { ?>
                                        <div class="uk-inline">
                                            <span class="uk-form-icon" uk-icon="icon: tag"></span>
                                            <input type="text" size="100" required
                                                   id="username"
                                                   name="username"
                                                   class="uk-input"
                                                   autocomplete="off"
                                                   placeholder="Введите username"
                                                   value=""/>
                                        </div>
                                        <p></p>
                                        <div class="uk-inline">
                                            <span class="uk-form-icon" uk-icon="icon: tag"></span>
                                            <input type="email" size="100" required
                                                   id="email"
                                                   name="email"
                                                   class="uk-input"
                                                   autocomplete="off"
                                                   placeholder="Введите email"
                                                   value=""/>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="uk-text-small uk-text-light uk-text-muted">
                                    add task. administrator will change state
                                </div>
                                <div class="uk-modal-footer uk-text-right">
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel
                                    </button>
                                    <input type="submit"
                                           class="uk-button uk-button-primary"
                                           value="Сохранить">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="login-section" uk-modal>
                    <div class="uk-modal-dialog">
                        <form action="index.php?auth=login" method="post">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <div class="uk-modal-header">
                                <h2 class="uk-modal-title">Войти</h2>
                            </div>
                            <div class="uk-modal-body">
                                <div class="uk-margin">
                                    <div class="uk-inline">
                                        <span class="uk-form-icon" uk-icon="icon: tag"></span>
                                        <input type="text" size="100" required
                                               id="username"
                                               name="username"
                                               class="uk-input"
                                               autocomplete="off"
                                               placeholder="Введите логин"
                                               value=""/>
                                    </div>
                                    <p></p>
                                    <div class="uk-inline">
                                        <span class="uk-form-icon" uk-icon="icon: comment"></span>
                                        <input type="password" size="100" required
                                               id="pass"
                                               name="pass"
                                               autocomplete="off"
                                               class="uk-input"
                                               placeholder="Введите пароль"
                                               value=""/>
                                    </div>
                                    <p></p>
                                </div>

                                <div class="uk-text-small uk-text-light uk-text-muted">
                                    admin:password
                                </div>
                                <div class="uk-modal-footer uk-text-right">
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel
                                    </button>
                                    <input type="submit"
                                           class="uk-button uk-button-primary"
                                           value="Сохранить">
                                    <div id="spinner" class="uk-hidden" uk-spinner
                                         style="padding-left: 1em;"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php if (!empty($tasks)) {
    foreach ($tasks as $task) { ?>
        <ul class="uk-list uk-list-striped">
            <li class="uk-flex uk-flex-between">
                <div class="task--description uk-flex uk-flex-middle uk-flex-around  uk-width-5-1">
                    <span class="task--body uk-width-4-1">
                        <?= @$task['body'] ?>
                    </span>
                    <span class="uk-width-1-6 uk-text-center" style="color: orange"><?= @$task['userData']['username'] ?></span>
                    <span class="uk-width-1-6 uk-text-center
                    <?php if ($task['state'] == 'New') {
                        echo "uk-text-primary\">{$task['state']}</span>"; ?>
                    <?php
                    } elseif ($task['state'] == 'Pending') echo "uk-text-danger\">{$task['state']}</span>";
                    else echo "uk-text-success\">{$task['state']}</span>" ?>
                </div>

                <?php if ($is_admin) { ?>

                    <div class=" list--action uk-flex uk-flex-middle uk-flex-center uk-width-1-6">
                    <a href="?task=edit&id=<?= @$task['id'] ?>" uk-icon="icon: file-edit"></a>
                    <a href="?task=delete&id=<?= @$task['id'] ?>" class="uk-margin-left" uk-icon="icon: trash"></a>
                </div>

                <? } ?>
            </li>
        </ul>
        <!--    <ul class="uk-list uk-list-striped">-->
        <!--        <li>-->
        <!--            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">-->
        <!--                --><?php //if ($is_admin) { ?>
        <!--                    <label><input class="uk-checkbox" type="checkbox" checked>-->
        <!--                        <span>--><? //= $task['body'] ?><!--</span>-->
        <!--                        --><?php //switch ($task['state']) {
//                            case 'New':
//                                echo "<span class=\"uk-label uk-label-success\">New</span>";
//                                break;
//                            case 'Complete':
//                                echo "<span class=\"uk-label uk-label-success\">Complete</span>";
//                                break;
//                            case 'Pending':
//                                echo "<span class=\"uk-label uk-label-success\">In progress</span>";
//                                break;
//                        } ?>
        <!--                    </label>-->
        <!---->
        <!--                --><?php //} else { ?>
        <!--                --><?php //} ?>
        <!--            </div>-->
        <!--        </li>-->
        <!--    </ul>-->
    <?php } ?>
    <ul class="uk-pagination">
        <?php if (!empty($prev_page)) { ?>
            <li><a href="?page=<?= $prev_page ?>"><span class="uk-margin-small-right" uk-pagination-previous></span>
                    Previous</a></li>
        <?php }
        if (!empty($next_page)) { ?>
            <li class="uk-margin-auto-left"><a href="?page=<?= $next_page ?>">Next <span class="uk-margin-small-left"
                                                                                         uk-pagination-next></span></a>
            </li>
        <?php } ?>
    </ul>
<?php }
$content = ob_get_clean() ?>

<?php include 'index.html.php' ?>