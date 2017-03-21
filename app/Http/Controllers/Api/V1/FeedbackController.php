<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <oss@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Nocarrier\Hal;

/**
 * Class FeedbackController.
 * @package App\Http\Controllers\Api\V1
 */
class FeedbackController extends Controller
{
    /**
     * Store feedback.
     *
     * @param FeedbackRequest $request
     * @return string
     */
    public function store(FeedbackRequest $request)
    {
        Feedback::create($request->all());

        $hal = new Hal(route('feedback.store'));
        $hal->setData([
            'success' => true,
        ]);

        return $hal->asJson();
    }

    /**
     * Get list of feedback options.
     *
     * @return string
     */
    public function options()
    {
        $hal = new Hal(route($this->getRouter()->currentRouteName()));
        $hal->setData([
            'POST' => [
                'description' => 'Post a feedback',
                'parameters' => [
                    'email' => [
                        'type' => 'string',
                        'description' => 'Sender e-mail',
                        'required' => 'false',
                    ],
                    'body' => [
                        'type' => 'string',
                        'description' => 'Message body',
                        'required' => 'true',
                    ],
                ],
                'example' => [
                    'email' => 'example@mail.com',
                    'body' => 'Hello guys! Your project is very SЁCUred!',
                ],
            ],
        ]);

        return $hal->asJson();
    }
}
