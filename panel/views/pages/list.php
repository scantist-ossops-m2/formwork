<?php if ($headers): ?>
    <div class="pages-list-headers" aria-hidden="true">
        <div class="pages-headers-cell page-details truncate"><?= $this->translate('panel.pages.page.title') ?></div>
        <div class="pages-headers-cell page-date truncate show-from-m"><?= $this->translate('panel.pages.page.lastModified') ?></div>
        <div class="pages-headers-cell page-status truncate show-from-xs"><?= $this->translate('panel.pages.page.status') ?></div>
        <div class="pages-headers-cell page-actions"><?= $this->translate('panel.pages.page.actions') ?></div>
    </div>
<?php endif ?>

<ul class="pages-list <?= $class ?>" data-orderable-children="<?= $orderable ? 'true' : 'false' ?>" <?php if ($parent): ?> data-parent="<?= $parent ?>" <?php endif ?>>
    <?php foreach ($pages as $page): ?>
        <?php $routable = $page->published() && $page->routable() ?>
        <?php $date = $this->datetime($page->contentFile()->lastModifiedTime()) ?>
        <li class="pages-item <?php if ($subpages): ?>pages-level-<?= $page->level() ?> <?php endif ?><?php if ($page->hasChildren()): ?>has-children <?php endif ?><?= $page->orderable() ? 'is-orderable' : 'is-not-orderable' ?>" data-route="<?= $page->route() ?>">
            <div class="pages-item-row">
                <div class="pages-item-cell page-details">
                    <div class="page-title flex">
                        <div class="sort-handle" style="min-width: 1rem" class="mr-2">
                            <?php if ($orderable && $page->orderable()): ?>
                                <span title="<?= $this->translate('panel.dragToReorder') ?>"><?= $this->icon('grabber') ?></span>
                            <?php endif ?>
                        </div>
                        <?php if ($subpages): ?>
                            <div style="min-width: 1rem" class="mr-2">
                                <?php if ($page->hasChildren()): ?>
                                    <button type="button" class="page-children-toggle" title="<?= $this->translate('panel.pages.toggleChildren') ?>" aria-label="<?= $this->translate('panel.pages.toggleChildren') ?>"><?= $this->icon('chevron-down') ?></button>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                        <div class="mr-2" style="min-width: 1rem"><?= $this->icon($page->get('icon', 'page')) ?></div>
                        <div class="min-w-0">
                            <div class="truncate text-color-accent"><a href="<?= $panel->uri('/pages/' . trim($page->route(), '/') . '/edit/') ?>"><?= $this->escape($page->title()) ?></a></div>
                            <?php foreach ($page->languages()->available() as $language): ?>
                                <span class="badge"><?= $language->code() ?></span>
                            <?php endforeach ?>
                            <div class="page-route truncate" aria-hidden="true">
                                <span><?= $page->canonicalRoute() ?? $page->route() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pages-item-cell page-date truncate show-from-m"><?= $date ?></div>
                <div class="pages-item-cell page-status page-status-<?= $page->status() ?> truncate show-from-xs">
                    <?= $this->icon('circle-small-fill') ?>
                    <span class="page-status-label"><?= $this->translate('panel.pages.status.' . $page->status()) ?></span>
                </div>
                <div class="pages-item-cell page-actions">
                    <a class="button button-link<?php if (!$page->published() || !$page->routable()): ?> disabled<?php endif ?>" role="button" <?php if ($page->published() && $page->routable()): ?>href="<?= $page->uri(includeLanguage: false) ?>" <?php endif ?> target="formwork-preview-<?= $page->uid() ?>" title="<?= $this->translate('panel.pages.preview') ?>" aria-label="<?= $this->translate('panel.pages.preview') ?>"><?= $this->icon('eye') ?></a>
                    <?php if ($panel->user()->permissions()->has('pages.delete')): ?>
                        <button type="button" class="button-link" data-modal="deletePageModal" data-modal-action="<?= $panel->uri('/pages/' . trim($page->route(), '/') . '/delete/') ?>" title="<?= $this->translate('panel.pages.deletePage') ?>" aria-label="<?= $this->translate('panel.pages.deletePage') ?>" <?php if (!$page->isDeletable()): ?> disabled<?php endif ?>><?= $this->icon('trash') ?></button>
                    <?php endif ?>
                </div>
            </div>
            <?php if ($subpages && $page->hasChildren()): ?>
                <?php $this->insert('pages.list', [
                    'pages'     => $page->scheme()->options()->get('children.reverse', false) ? $page->children()->reverse() : $page->children(),
                    'subpages'  => true,
                    'class'     => 'pages-children',
                    'parent'    => $page->route(),
                    'orderable' => $orderable && $page->scheme()->options()->get('children.orderable', true),
                    'headers'   => false,
                ]) ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>
</ul>
