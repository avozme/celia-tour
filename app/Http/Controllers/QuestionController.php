<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\Resource;
use DB;

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
            'answer' => 'required',
        ]);

        $addQuestion = new Question();
        $addQuestion->text = $request->text;
        $addQuestion->answer = $request->answer;
        $addQuestion->key = 0;
        $addQuestion->id_audio = $request->audio;
        $addQuestion->id_escaperoom = $request->id_escaperoom;
        $addQuestion->type = $request->type;
        $addQuestion->id_resource = $request->id_resource;
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
        $updateQuestion = Question::find($id);
        $updateQuestion->text = $request->text;
        $updateQuestion->answer = $request->answer;
        $updateQuestion->key = 0;
        $updateQuestion->id_hide = NULL;
        $idAudio = $request->id_audio;
        $updateQuestion->id_audio = $idAudio;
        
        $updateQuestion->save();
        
        if($idAudio != null){
            $audio = Resource::find($idAudio);
            
            return response()->json(['question' => $updateQuestion,'idAudio' => $audio->id, 'titleAudio' => $audio->title, 'routeAudio' => $audio->route]);
        }else{
            return response()->json(['question' => $updateQuestion]);
        }

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

    public function getQuestionFromHide($idHide){
        $question = DB::table('questions')->where('id_hide', $idHide)->get();
        if(count($question) > 0){
            return response()->json(['status' => true, 'question' => $question[0]]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function getRoute(Question $id){
        return response()->json($id->text);
    }

    /**
     * DEVUELVE LAS PREGUNTAS SEGUN EL FILTRO ESPECIFICADO
     */
    public function filter($filter){
        switch ($filter) {
            case 'all':
                $questions = DB::table('questions')->select("id")->get();;
                break;
            case 'assigned':
                $questions = DB::table('questions')->where('id_hide', '!=', null)->select("id")->get();;
                break;
            case 'not-assigned':
                $questions = DB::table('questions')->where('id_hide', null)->select("id")->get();;
                break;
        }
        return response()->json($questions);
    }

}
