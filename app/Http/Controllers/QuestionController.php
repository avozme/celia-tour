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
        
    }

    /**
     * DEVUELVE LA PREGUNTA PARA EDITARLA
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return response()->json($question);
    }

    /**
     * ACTUALIZA UNA PREGUNTA EN LA BASE DE DATOS
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'text' => 'required',
        //     'type' => 'required',
        //     'key' => 'required',
        //     'show_clue' => 'required'
        // ]);

        $updateQuestion = Question::find($id);
        $updateQuestion->text = $request->text;
        $updateQuestion->type = $request->type;
        $updateQuestion->key = $request->key;
        $updateQuestion->show_clue = $request->show_clue;
        if(isset($request->answer)) {
            $updateQuestion->answers_id = $request->answer;
        }
        $updateQuestion->save();
        
        return response()->json($updateQuestion);
    }

    /**
     * ELIMINA UNA PREGUNTA DE LA BASE DE DATOS
     */
    public function destroy($id)
    {
        $question = Question::destroy($id);
        return response()->json($question);
    }

    public function getAll(){
        $questions = Question::all();
        return response()->json(['questions' => $questions]);
    }

    public function updateIdHide($idQuestion, Request $r){
        $q = Question::find($idQuestion);
        $q->id_hide = $r->idHide;
        if($q->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

}
