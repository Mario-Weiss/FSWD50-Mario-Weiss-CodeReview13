<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerAyepxdi\appDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerAyepxdi/appDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerAyepxdi.legacy');

    return;
}

if (!\class_exists(appDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerAyepxdi\appDevDebugProjectContainer::class, appDevDebugProjectContainer::class, false);
}

return new \ContainerAyepxdi\appDevDebugProjectContainer(array(
    'container.build_hash' => 'Ayepxdi',
    'container.build_id' => '9163edb3',
    'container.build_time' => 1543684147,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerAyepxdi');
