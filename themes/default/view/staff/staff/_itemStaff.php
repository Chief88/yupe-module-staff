<li class="team-list__item">
    <div class="team-list__image">
        <img src="<?= $data->getImageUrl(210, 296); ?>" alt="<?= $data->first_name; ?>" />
    </div>
    <div class="team-list__name">
        <?= $data->last_name; ?> <?= $data->first_name; ?> <?= $data->patronymic; ?>
    </div>
    <div class="team-list__desc">
        <?= $data->data; ?>
        <p><a href="#">Ближайшие занятия</a></p>
    </div>