<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
    <body>
        <form method="GET" action="/">
            <div>
                <label for="type">Тип недвижимости:</label><br>
                <select name="type" id="type">
                    <?php
                        foreach ($typesFlat as $type) { ?>
                            <option value="<?php echo $type->getId();?>"
                                <?php if ($request->getRequestParamByKey('type') === $type->getId()) { ?>
                                    selected
                                <?php } ?>
                            ><?php echo $type->getName(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <br>
            <div>
                <label for="price">Цена от и до:</label><br>
                <input id="price" name="price[from]" value="<?php
                    $price = $request->getRequestParamByKey('price');
                    if (!empty($price) && !empty($price['from'])) {
                      echo $price['from'];
                    } ?>"> - <input name="price[to]" value="<?php
                    if (!empty($price) && !empty($price['to'])) {
                      echo $price['to'];
                    } ?>">
            </div>
            <br>
            <div>
                <label for="rooms">Комнаты:</label><br>
                <select id="rooms" name="rooms[]" multiple>
                    <?php
                        foreach ($roomsAmountTypes as $room) { ?>
                            <option value="<?php echo $room->getId(); ?>" <?php
                                $selectedRooms = $request->getRequestParamByKey('rooms');
                                foreach ($selectedRooms as $selected) {
                                    if ($selected === $room->getId()) {
                                        echo 'selected';
                                    }
                                }
                            ?>><?php echo $room->getName(); ?></option>
                    <?php } ?>
                </select>
            </div>
            <br>
            <div>
                <label>
                    <input type="checkbox" name="only_photo" value="1" <?php
                        if (!empty($request->getRequestParamByKey('only_photo'))) {
                            echo 'checked';
                        }
                    ?>> только с фото
                </label>
            </div>
            <br>
            <div>
                <button type="submit">Поиск</button>
            </div>
        </form>
        <br>
        <table width="100%">
            <thead>
                <tr>
                    <th>Адрес</th>
                    <th>Фотографий</th>
                    <th>Ком.</th>
                    <th>Общ./Жил./Кух.</th>
                    <th>Этаж</th>
                    <th>Дом</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($apartments as $apartment) { ?>
                    <tr>
                        <td><?php echo $apartment->getAddress(); ?></td>
                        <td align="center"><?php echo $apartment->getAmauntPhoto(); ?></td>
                        <td align="center"><?php echo $apartment->getRooms(); ?></td>
                        <td align="center"><?php echo $apartment->getFootage(); ?></td>
                        <td align="center"><?php echo $apartment->getFloor(); ?></td>
                        <td align="center"><?php echo $apartment->getTypeBuilding(); ?></td>
                        <td align="right"><strong><?php echo $apartment->getPrice(); ?></strong> <?php echo $apartment->getCurrency(); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <ul>
            <?php foreach ($pagination as $page) { ?>
                <li><?php echo $page; ?></li>
            <?php } ?>
        </ul>
    </body>
</html>