<?php

declare(strict_types=1);

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Api\Feedback;

use App\Models\Feedback;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;

class PostFeedbackController
{
    public function __invoke(
        PostFeedbackRequest $request
    ): ResponsableContract {
        Feedback::query()->create($request->validated());

        $data = [
            'success' => true,
        ];

        return new PostFeedbackResponse($data);
    }
}
