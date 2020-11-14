<?php
/**
 * Created by PhpStorm.
 * User: sergejivanov
 * Date: 09.08.2019
 * Time: 20:56
 */

namespace reactmay\WoWAuth\Models\Characters;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CharacterStats extends Eloquent
{
    protected $connection = 'characters';
    protected $primaryKey = 'guid';
    protected $table = 'character_stats';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'maxhealth',
        'maxpower1',
        'maxpower2',
        'maxpower3',
        'maxpower4',
        'maxpower5',
        'maxpower6',
        'maxpower7',
        'strength',
        'agility',
        'stamina',
        'intellect',
        'spirit',
        'armor',
        'resHoly',
        'resFire',
        'resNature',
        'resFrost',
        'resShadow',
        'resArcane',
        'blockPct',
        'dodgePct',
        'parryPct',
        'critPct',
        'rangedCritPct',
        'spellCritPct',
        'attackPower',
        'rangedAttackPower',
        'spellPower',
        'resilience'
    ];
}
