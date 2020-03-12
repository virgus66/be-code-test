<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        
    ];
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'name'      => (string) $organisation->name,
            'trial_end' => (string) $organisation->trial_end,
            'subscribed'=> (boolean) $organisation->subscribed,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation)
    {
        $user = $organisation->owner;
        return $this->item($user, new UserTransformer());
    }
}
