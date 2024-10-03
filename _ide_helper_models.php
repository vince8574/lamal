<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prime> $primes
 * @property-read int|null $primes_count
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgeRange whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAgeRange {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prime> $primes
 * @property-read int|null $primes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Canton newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Canton newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Canton query()
 * @method static \Illuminate\Database\Eloquent\Builder|Canton whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Canton whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Canton whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Canton whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Canton whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCanton {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prime> $primes
 * @property-read int|null $primes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise query()
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Franchise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFranchise {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $bag_number
 * @property string $loc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereBagNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereLoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInsurer {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $insurer_id
 * @property int $canton_id
 * @property int $year
 * @property string $region_code
 * @property int $age_range_id
 * @property int $accident
 * @property string $tarif
 * @property string $franchise_class
 * @property int $franchise_id
 * @property string $cost
 * @property string $tarif_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AgeRange|null $age_range
 * @property-read \App\Models\Canton|null $canton
 * @property-read \App\Models\Franchise|null $franchise
 * @property-read \App\Models\Insurer|null $insurer
 * @method static \Illuminate\Database\Eloquent\Builder|Prime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prime query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereAccident($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereAgeRangeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereCantonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereFranchiseClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereFranchiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereInsurerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereTarif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereTarifName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prime whereYear($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPrime {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

