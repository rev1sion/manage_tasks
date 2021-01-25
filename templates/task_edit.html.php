<?php

$title = 'Edit task' ?>

<?php ob_start(); ?>

    <section class="uk-section">
        <div class="uk-container">
            <div class="uk-float-right header__actions">
                <a class="uk-button uk-button-default" href="index.php?auth=logout" uk-toggle>Logout</a>
            </div>
            <div class="uk-margin">
                <form action="index.php?task=update" method="post">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <div class="uk-modal-header">
                        <h2 class="uk-modal-title">Edit task</h2>
                    </div>
                    <div class="uk-modal-body">
                        <div class="uk-margin">
                                <textarea id="body"
                                          class="uk-textarea uk-child-width"
                                          rows="5"
                                          name="body"
                                          placeholder="Task body"
                                ><?= $task['body'] ?></textarea>
                            <p></p>
                                <select id="username"
                                        class="uk-select"
                                        name="username">
                                    <?php foreach ($users as $user) { ?>
                                        <option <?php if ($user['username'] == $task['userData']['username']) echo 'selected' ?>
                                                value="<?= $user['username'] ?>">
                                            <?= $user['username'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <p></p>
                                <select id="state"
                                        class="uk-select"
                                        name="state">
                                    <option selected value="New">
                                        New
                                    </option>
                                    <option value="Pending">
                                        Pending
                                    </option>
                                    <option value="Done">
                                        done
                                    </option>
                                </select>

                                <input type="hidden" size="100" hidden
                                       id="task"
                                       name="taskId"
                                       class="uk-input"
                                       autocomplete="off"
                                       value="<?= $task['id'] ?>"/>
                        </div>

                        <div class="uk-text-small uk-text-light uk-text-muted">
                            add task. administrator will change state
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <a href="/" class="uk-button uk-button-default uk-modal-close" type="button">Cancel
                            </a>
                            <input type="submit"
                                   class="uk-button uk-button-primary"
                                   value="Сохранить">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

<?php $content = ob_get_clean() ?>

<?php include 'index.html.php' ?>