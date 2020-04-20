<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;

class QuestionController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL
     */
    public function index()
    {
        $data['question'] = Question::all();
        $data['answer'] = Answer::all();
        return view('backend.question.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * METODO PARA ALMACENAR UNA NUEVA PREGUNTA EN LA BASE DE DATOS
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'type' => 'required',
            'key' => 'required',
            'show_clue' => 'required'
        ]);

        $addQuestion = new Question();
        $addQuestion->text = $request->text;
        $addQuestion->type = $request->type;
        $addQuestion->key = $request->key;
        $addQuestion->show_clue = $request->show_clue;
        if(isset($request->answer)) {
            $addQuestion->answers_id = $request->answer;
        }
        $addQuestion->save();
        // return redirect()->route('question.index');
        return response()->json($addQuestion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * ELIMINA UNA PREGUNTA DE LA BASE DE DATOS
     */
    public function destroy($id)
    {
        $question = Question::destroy($id);
        return response()->json($question);
    }
}
