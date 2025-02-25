<?php $this->layout('panel') ?>
<form method="post" data-form="page-editor-form" enctype="multipart/form-data">
    <div class="header">
        <div class="min-w-0 flex-grow-1">
            <div class="header-title"><?= $this->icon($page->get('icon', 'page')) ?> <?= $this->escape($page->title()) ?></div>
            <div class="flex">
                <div><?= $this->insert('_pages/status', ['page' => $page]) ?></div>
                <?php if (!$page->isIndexPage() && !$page->isErrorPage()) : ?>
                    <div class="page-route page-route-changeable min-w-0">
                        <button type="button" class="button page-slug-change truncate max-w-100" data-command="change-slug" title="<?= $this->translate('panel.pages.changeSlug') ?>"><span class="page-route-inner"><?= $page->route() ?></span> <?= $this->icon('pencil') ?></button>
                    </div>
                <?php else : ?>
                    <div class="page-route"><?= $page->route() ?></div>
                <?php endif ?>
            </div>
        </div>
        <input type="hidden" id="slug" name="slug" value="<?= $page->slug() ?>">
        <?php if ($currentLanguage) : ?>
            <input type="hidden" id="language" name="language" value="<?= $currentLanguage ?>">
        <?php endif ?>
        <div>
            <a class="<?= $this->classes(['button', 'button-link', 'show-from-md', 'disabled' => !$page->previousSibling()]) ?>" role="button" <?php if ($page->previousSibling()) : ?>href="<?= $panel->uri('/pages/' . trim($page->previousSibling()->route(), '/') . '/edit/') ?>" <?php endif ?> title="<?= $this->translate('panel.pages.previous') ?>" aria-label="<?= $this->translate('panel.pages.previous') ?>"><?= $this->icon('chevron-left') ?></a>
            <a class="<?= $this->classes(['button', 'button-link', 'show-from-md', 'disabled' => !$page->nextSibling()]) ?>" role="button" <?php if ($page->nextSibling()) : ?>href="<?= $panel->uri('/pages/' . trim($page->nextSibling()->route(), '/') . '/edit/') ?>" <?php endif ?> title="<?= $this->translate('panel.pages.next') ?>" aria-label="<?= $this->translate('panel.pages.next') ?>"><?= $this->icon('chevron-right') ?></a>
            <a class="<?= $this->classes(['button', 'button-link', 'disabled' => !$page->published() || !$page->routable()]) ?>" role="button" <?php if ($page->published() && $page->routable()) : ?>href="<?= $page->uri(includeLanguage: $currentLanguage ?: true) ?>" <?php endif ?> target="formwork-preview-<?= $page->uid() ?>" title="<?= $this->translate('panel.pages.preview') ?>" aria-label="<?= $this->translate('panel.pages.preview') ?>"><?= $this->icon('eye') ?></a>
            <?php if ($panel->user()->permissions()->has('pages.delete')) : ?>
                <button type="button" class="button button-link" data-modal="deletePageModal" data-modal-action="<?= $panel->uri('/pages/' . trim($page->route(), '/') . '/delete/' . ($currentLanguage ? 'language/' . $currentLanguage . '/' : '')) ?>" title="<?= $this->translate('panel.pages.deletePage') ?>" aria-label="<?= $this->translate('panel.pages.deletePage') ?>" <?php if (!$page->isDeletable()) : ?> disabled<?php endif ?>><?= $this->icon('trash') ?></button>
            <?php endif ?>
            <?php if (!$site->languages()->available()->isEmpty()) : ?>
                <div class="dropdown">
                    <button type="button" class="button dropdown-button caret button-accent" data-dropdown="languages-dropdown"><?= $this->icon('translate') ?> <?= $this->translate('panel.pages.languages') ?><?php if ($currentLanguage) : ?> <span class="badge"><?= $currentLanguage ?></span><?php endif ?></button>
                    <div class="dropdown-menu" id="languages-dropdown">
                        <?php foreach ($site->languages()->available() as $language) : ?>
                            <a href="<?= $panel->uri('/pages/' . trim($page->route(), '/') . '/edit/language/' . $language . '/') ?>" class="dropdown-item"><?= $page->languages()->available()->has($language) ? $this->translate('panel.pages.languages.editLanguage', $language->nativeName() . ' (' . $language->code() . ')') : $this->translate('panel.pages.languages.editLanguage', $language->nativeName() . ' (' . $language->code() . ')') ?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
            <button type="submit" class="button button-accent mb-0" data-command="save"><?= $this->icon('check-circle') ?> <?= $this->translate('panel.pages.save') ?></button>
        </div>
    </div>
    <div>
        <?php $this->insert('fields', ['fields' => $fields]) ?>
    </div>
    <input type="hidden" name="csrf-token" value="<?= $csrfToken ?>">
</form>