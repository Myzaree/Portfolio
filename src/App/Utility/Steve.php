<?php
namespace App\Utility;

use InvalidArgumentException;

abstract class Steve
{
    protected static $name;
    protected static $note;
    protected static $notes;
    protected static $steve;

    public static function initialize()
    {
        $time = self::time();
        $memory = self::memory();

        self::$name = null;
        self::$note = null;
        self::$notes = array();

        self::$steve = array(
            'start' => array('time' => $time, 'memory' => $memory),
            'finish' => array('time' => null, 'memory' => null)
        );
    }

    public static function note($name)
    {
        if (in_array($name, array_keys(self::$notes)))
            throw new InvalidArgumentException(sprintf('Steve::note("%s") already exists', $name));

        // close previous note
        if (self::$note && !self::$notes[self::$note]['closed'])
            self::close(self::$note);

        $time = self::time();
        $memory = self::memory();

        self::$note = $name;
        self::$notes[$name] = array(
            'closed' => false,
            'start' => array('time' => $time, 'memory' => $memory),
            'finish' => array('time' => null, 'memory' => null)
        );
    }

    public static function close($name)
    {
        if (false === array_search($name, array_keys(self::$notes)))
            throw new InvalidArgumentException(sprintf('Steve::close("%s") does not exist', $name));

        if (true === self::$notes[$name]['closed'])
            throw new InvalidArgumentException(sprintf('Steve::close("%s") already closed', $name));

        $time = self::time();
        $memory = self::memory();

        self::$notes[$name]['closed'] = true;
        self::$notes[$name]['finish'] = array('time' => $time, 'memory' => $memory);
    }

    public static function results()
    {
        if (self::$note && !self::$notes[self::$note]['closed'])
            self::close(self::$note);

        self::$steve['finish'] = array('time' => self::time(), 'memory' => self::memory());

        $results = array(
            'total' => array(
                'time' => self::$steve['finish']['time'] - self::$steve['start']['time'],
                'memory' => self::$steve['finish']['memory'] - self::$steve['start']['memory']
            ),
            'calculated' => array('time' => 0, 'memory' => 0)
        );

        $pad = 2 + strlen(self::formatTime($results['total']['time']));

        echo '<pre>';
        self::line(self::leftPad(self::formatTime($results['total']['time']), $pad) . ' [Total]');
        self::line(self::leftPad(self::formatMemory($results['total']['memory']), $pad));
        self::line(str_repeat('-', $pad));

        foreach(self::$notes as $name => $note) {
            $result = array(
                'time' => $note['finish']['time'] - $note['start']['time'],
                'memory' => $note['finish']['memory'] - $note['start']['memory']
            );

            $results['calculated']['time'] += $result['time'];
            $results['calculated']['memory'] += $result['memory'];

            self::line(self::leftPad(self::formatTime($result['time']), $pad) . sprintf(' [%s]', $name));
            self::line(self::leftPad(self::formatMemory($result['memory']), $pad));
            self::line(str_repeat('-', $pad));
        }

        self::line(self::leftPad(self::formatTime($results['total']['time'] - $results['calculated']['time']), $pad) . ' [Untracked]');
        self::line(self::leftPad(self::formatMemory($results['total']['memory'] - $results['calculated']['memory']), $pad));
        echo '</pre>';
    }

    public static function line($line)
    {
        echo $line . "\n";
    }

    public static function leftPad($string, $padding)
    {
        return str_pad($string, $padding, ' ', STR_PAD_LEFT);
    }

    public static function memory()
    {
        return memory_get_usage();
    }

    public static function time()
    {
        return round(microtime(true), 3);
    }

    public static function formatTime($time)
    {
        return number_format($time * 1000, 2) . 'ms';
    }

    public static function formatMemory($bytes)
    {
        $size = array('b ', 'kb', 'mb', 'gb', 'tb');
        $factor = (int) floor((strlen($bytes) - 1) / 3);
        return number_format($bytes / pow(1024, $factor), 2) . $size[$factor];
    }
}
