<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Question;
use App\Modules\Electrons\Questions\QuestionService;
use App\Modules\Electrons\Questions\ChoiceService;
use App\Modules\Electrons\Questions\AnswerService;
use App\Modules\Api\V1\Requests\Questions\QuestionIndexRequest;
use App\Modules\Api\V1\Requests\Questions\QuestionInsertRequest;
use App\Modules\Api\V1\Requests\Questions\QuestionUpdateRequest;
use App\Modules\Api\V1\Requests\Questions\AddChoicesRequest;
use App\Modules\Api\V1\Requests\Choices\ChoiceIndexRequest;
use App\Modules\Api\V1\Requests\Answers\AnswerIndexRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use JsonApiController;

    /**
     * A question service instance.
     *
     * @var QuestionService
     */
    protected $questions;

    /**
     * Create a new controller instance.
     *
     * @param  QuestionService  $questions
     * @return void
     */
    public function __construct(QuestionService $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Get an array of questions data.
     *
     * @param  QuestionIndexRequest  $request
     * @return Response
     */
    public function index(QuestionIndexRequest $request)
    {
        return $this->respondJson(
            ['questions' => $this->questions->getMultiple($request->all())]
        );
    }

    /**
     * Get a question data.
     *
     * @param  Request   $request
     * @param  Question  $question
     * @return Response
     */
    public function show(Request $request, Question $question)
    {
        $this->authorize('view', $question);

        return $this->respondJson(['question' => $question]);   
    }

    /**
     * Insert a new question data.
     *
     * @param  QuestionInsertRequest  $request
     * @return Response
     */
    public function insert(QuestionInsertRequest $request)
    {
        $question = $this->questions->create($request->all());

        return $this->respondJson(['question' => $question]);
    }

    /**
     * Update a question data.
     *
     * @param  QuestionUpdateRequest  $request
     * @param  Question               $question
     * @return Response
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $this->questions->update($question, $request->all());

        return $this->respondJson(['question' => $question]);
    }

    /**
     * Delete a question data.
     *
     * @param  Request   $request
     * @param  Question  $question
     * @return Response
     */
    public function remove(Request $request, Question $question)
    {
        $this->authorize('delete', $question);

        $this->questions->remove($question);

        return $this->respondJson(['question' => $question]);
    }

    /**
     * Get the choices of given question.
     * 
     * @param  ChoiceIndexRequest  $request
     * @param  Question            $question
     * @param  ChoiceService       $choices
     * @param  Response
     */
    public function choices(ChoiceIndexRequest $request, Question $question, ChoiceService $choices)
    {
        $queries = $request->all();

        $queries['question'] = $question->id;

        return $this->respondJson(
            ['choices' => $choices->getMultiple($queries)]
        );
    }

    /**
     * Add multiple choices to the given question.
     *
     * @param  AddChoicesRequest  $request
     * @param  Question           $question
     * @param  ChoiceService      $choices
     * @return Response
     */
    public function addChoices(AddChoicesRequest $request, Question $question, ChoiceService $choices)
    {
        $choices = $choices->createMultiple(
            $question->id, $request->input('choices')
        );

        return $this->respondJson(['choices' => $choices]);
    }

    /**
     * Get the answers of given question.
     * 
     * @param  AnswerIndexRequest  $request
     * @param  Question            $question
     * @param  AnswerService       $answers
     * @param  Response
     */
    public function answers(AnswerIndexRequest $request, Question $question, AnswerService $answers)
    {
        $queries = $request->all();

        $queries['question'] = $question->id;

        return $this->respondJson(
            ['answers' => $answers->getMultiple($queries)]
        );
    }
}
