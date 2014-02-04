<?php

// Contains simple debugging helper functionality
// Update to handle circular references: http://us1.php.net/manual/en/class.splobjectstorage.php
function dump($data) {
    // display headers for each data set
    if (is_object($data) || is_array($data)) {
        $arr_obj = new \ArrayObject($data);

        echo '<pre style="display: inline; margin: 0;"><strong>' . gettype($data) . '</strong>';
        echo '(<em>' . (is_object($data) ? get_class($data) : '') . '</em>)';
        echo ' (' . $arr_obj->count() . ')</pre>';

        // format object properties
        if (is_object($data)) {
            $object_data = [];
            $reflection = new \ReflectionClass($data);
            $properties = $reflection->getProperties();

            foreach ($properties as $property) {
                $property->setAccessible(true);

                $key  = '"' . $property->getName() . '"';
                $key .= $property->isProtected() ? ':protected' : '';
                $key .= $property->isPrivate() ? ':private' : '';
                $object_data[$key] = $property->getValue($data);
            }

            foreach (get_object_vars($data) as $key => $value) {
                $object_data['"' . $key . '"'] = $value;
            }

            $data = $object_data;
        } else {
            $array_data = [];

            // format array names
            foreach ($data as $key => $value) {
                $array_data['"' . $key . '"'] = $value;
            }

            $data = $array_data;
        }

        // normalize spacing
        $pad = ['key' => 0, 'type' => 0];
        foreach ($data as $key => $value) {
            $pad['key'] = (strlen($key) + 4 > $pad['key']) ? (strlen($key) + 4) : $pad['key'];
            $pad['type'] = (strlen(gettype($value)) + 6 > $pad['type']) ? (strlen(gettype($value)) + 6) : $pad['type'];
        }

        echo '<ul style="list-style: none; margin: 0 0 10px 20px; padding: 0;">';
        foreach ($data as $key => $value) {
            if (is_object($value) || is_array($value)) {
                echo '<li style="margin: 4px 0;"><pre style="display: inline; margin: 0;">' . $key . ' </pre>';
                dump($value);
                echo '</li>';
                continue;
            }

            $color =
                is_bool($value) ? '7f5885' :
                    (is_int($value) ? '4e9a06' :
                        (is_float($value) ? 'f57900' :
                            'c00'))
            ;

            echo '<li><pre style="margin: 0 0 0 0">' . str_pad($key, $pad['key']);
            echo '<span style="color: #000; font-size: 0.8em">' . str_pad(gettype($value) . ' ' . strlen($value), $pad['type']) . '</span>';
            echo '<span style="color: #' . $color . '">' . htmlspecialchars(var_export($value, true)) . '</span></pre></li>';

        }
        echo '</ul>';
    } else {
        $color = !is_string($data) ? (is_float($data) ? 'f57900' : '4e9a06') : 'c00';
        echo '<pre>';
        echo '<span style="font-size: 0.8em">' . gettype($data) . '</span>';
        echo '<span style="white-space: pre-wrap; color: #' . $color . '"> ' . htmlspecialchars(var_export($data, true)) . '</span></pre>';
    }
}
