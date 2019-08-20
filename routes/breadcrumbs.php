<?php

// Home
Breadcrumbs::for('records.index', function ($trail) {
    $trail->push('Home', route('records.index'));
});

Breadcrumbs::for('records.create', function ($trail) {
    $trail->parent('records.index');
    $trail->push("New", route('records.create'));
});

Breadcrumbs::for('records.show', function ($trail, $record) {
    $trail->parent('records.index');
    $trail->push($record->name, route('records.show', $record->id));
});

Breadcrumbs::for('records.edit', function ($trail, $record) {
    $trail->parent('records.show', $record);
    $trail->push("Edit", route('records.edit', $record->id));
});

Breadcrumbs::for('lyrics.sync', function ($trail, $record) {
    $trail->parent('records.edit', $record);
    $trail->push("Sync", route('records.lyrics.sync', $record->id));
});

