<?php

function dump($data) {
    static $objHashes = array();
    static $objects = null;

    $objects = ((is_null($objects)) ? new \SplObjectStorage() : $objects);

    $colors = array(
        'default'   => '#000000', // black
        'dark'      => '#1e2222', // dark shadow
        'medium'    => '#363c3d', // medium shadow
        'light'     => '#4e5758', // light shadow

        'NULL'      => '#8e44ad', // amethyst
        'boolean'   => '#8e44ad', // amethyst
        'integer'   => '#219251', // emerald
        'double'    => '#d35400', // pumpkin
        'string'    => '#c0392b', // pomegranate
        'recursion' => '#2980b9', // belize hole
    );

    $getColor = function ($data) use ($colors) {
        return isset($colors[gettype($data)]) ? $colors[gettype($data)] : $colors['default'];
    };

    $getMaxLength = function ($arr) {
        return max(array_map('strlen', $arr));
    };

    // output simple data and exit
    if (!is_array($data) && !is_object($data)) {
        $color = $getColor($data);
        $type = str_pad(gettype($data), $getMaxLength(array_keys($colors)) + 1);
        $data = var_export($data, true);

        echo sprintf('<pre style="white-space: normal; word-wrap: break-word; margin: 3px 0;"><span style="color: %s; font-size: 0.85em;">%s</span>', $colors['light'], $type);
        echo sprintf('<span style="white-space: pre-wrap; color: %s;">%s</span></pre>', $color, $data);
        return;
    }

    // save object hashes for recursion detection
    $hash = null;

    if (is_object($data)) {
        $hash = spl_object_hash($data);
        $current = count($objHashes) ? max($objHashes) + 1 : 1;
        $objHashes[$hash] = isset($objHashes[$hash]) ? $objHashes[$hash] : $current;
    }

    // display the headers for objects and arrays
    $class = is_object($data) ? get_class($data) : count((array) $data);
    $objId = is_object($data) ? '#' . $objHashes[$hash] : '';

    echo sprintf('<pre style="white-space: pre-wrap; word-wrap: break-word; display: inline; margin: 0; color: %s;"><strong>%s</strong>', $colors['default'], gettype($data));
    echo sprintf('(<span style="color: %s">%s</span>) %s</pre>', $colors['light'], $class, $objId);

    // retrieve object data
    if ($data instanceof stdClass) {
        $objData = array();

        foreach($data as $property => $value) {
            $objData[$property] = $value;
        }

        $data = $objData;
    }

    if (is_object($data)) {
        $objData = array();
        $objReflection = new \ReflectionClass($data);
        $objProperties = $objReflection->getProperties();

        foreach ($objProperties as $property) {
            $property->setAccessible(true);
            $key  = sprintf('"%s"', $property->getName());
            $key .= $property->isPublic() ? ':public' : '';
            $key .= $property->isProtected() ? ':protected' : '';
            $key .= $property->isPrivate() ? ':private' : '';

            $objData[$key] = $property->getValue($data);
        }

        $data = $objData;
    }

    // normalize spacing on the longest key
    $paddingKey = (count($data) ? max(array_map('strlen', array_keys($data))) + 3 : 0);

    // output the results in a new list
    if (count($data) == 0) {
        echo '<br>';
        return;
    }

    echo '<ul style="list-style: none; margin: 2px 0 10px 20px; padding: 0;">';
    foreach ($data as $key => $value) {
        // display objects
        if (is_object($value)) {
            // check for recursion
            if ($objects->contains($value)) {
                $hash = spl_object_hash($value);

                echo sprintf('<pre style="white-space: pre-wrap; word-wrap: break-word; display: inline; margin: 0; color: %s;"><strong>%s</strong>', $getColor($value), gettype($value));
                echo sprintf('(<span style="color: %s">%s</span>) #%d </pre>', $colors['light'], get_class($value), $objHashes[$hash]);
                echo sprintf('<span style="color: %s;">*RECURSION*</span><br>', $colors['recursion']);
                continue;
            }

            $objects->attach($value);
        }

        // display array and object results
        if (is_object($value) || is_array($value)) {
            echo sprintf('<li style="margin: 0;"><pre style="color: %s; display: inline; margin: 0;">[%s] </pre>', $colors['dark'], $key);
            dump($value);
            echo '</li>';
            continue;
        }

        // display simple data
        $color = $getColor($value);
        $key = str_pad(sprintf('[%s]', $key), $paddingKey);
        $type = str_pad(gettype($value), $getMaxLength(array_keys($colors)) + 2);
        $value = var_export($value, true);

        echo sprintf('<li><pre style="white-space: pre-wrap; word-wrap: break-word; margin: 2px 0 0 0; color: %s;">%s', $colors['dark'], $key);
        echo sprintf('<span style="color: %s; font-size: 0.85em">%s</span>', $colors['light'], $type);
        echo sprintf('<span style="color: %s;">%s</span></pre></li>', $color, $value);
    }
    echo '</ul>';
}
