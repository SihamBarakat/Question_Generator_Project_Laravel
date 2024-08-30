<?php
//generate question as word file then as pdf file
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Saved;
use DB;
use PDF;


class GenerateController extends Controller
{
    
    public function msword(Request $request)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $text = $section->addText($request->get('emp_name'));
        $text = $section->addText($request->get('emp_salary'));
        $text = $section->addText($request->get('emp_age'),array('name'=>'Arial','size' => 20,'bold' => true));
          
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Appdividend.docx');
        return response()->download(public_path('phpflow.docx'));
    }
    public function generateQuestion()
    {
    	$subjects = DB::table('subjects')
    		->where('publicationStatus',1)
    		->get();
		$departments = DB::table('departments')
			->where('publicationStatus',1)
			->get();
    	return view('admin.generateQuestion.generateQuestion',['subjects'=>$subjects,'departments'=>$departments]);
    }
    public function generateQuestionPost(Request $request)
    {
        $subject = DB::table('subjects')
            ->where('id',$request->subject)
            ->first();
        $sub = $subject->subjectName;
        //$subCode = $subject->subjectCode;
        $mark=10*$request->numberOfQuestions;
        
        $data = array(
            
            'examName'    => $request->examName,
            'semester'    => $request->semester,
            'subject'     => $sub,
            'subjectCode' => $subCode,
            'time'        => $request->time,
            'date'        => $request->date,
            'marks'       => $mark,
            'note'        => $request->note,
        );
        $questions1 = DB::table('exam')
            ->where('publicationStatus',1)
            ->where('subjectId',$subject->id)
            ->where('questionDifficultyLevel','<=',$request->examDifficulty)
            ->where('questionMarks',1)
            ->take($request->numberOfQuestions)
            ->get();
        $questions2 = DB::table('broad_questions')
            ->where('publicationStatus',1)
            ->where('subjectId',$subject->id)
            ->where('questionDifficultyLevel','<=',$request->examDifficulty)
            ->where('questionMarks',2)
            ->take($request->numberOfQuestions)
            ->get();
        $questions3 = DB::table('broad_questions')
            ->where('publicationStatus',1)
            ->where('subjectId',$subject->id)
            ->where('questionDifficultyLevel','<=',$request->examDifficulty)
            ->where('questionMarks',3)
            ->take($request->numberOfQuestions)
            ->get();
        $questions4 = DB::table('broad_questions')
            ->where('publicationStatus',1)
            ->where('subjectId',$subject->id)
            ->where('questionDifficultyLevel','<=',$request->examDifficulty)
            ->where('questionMarks',4)
            ->take($request->numberOfQuestions)
            ->get();
        if($request['sub']=='sub')
        {
            $v =  view('admin.question.questionPaper',['questions1'=>$questions1,'questions2'=>$questions2,'questions3'=>$questions3,'questions4'=>$questions4])->with($data);
            return $v;
        }
    	else
        {
            $name = rand(100000000,300000000);
            $pdf = PDF::loadView('test',['questions1'=>$questions1,'questions2'=>$questions2,'questions3'=>$questions3,'questions4'=>$questions4,'data'=>$data])->save('public/qp/'.$name.'.pdf');
            $name = '/qp/'.$name.'.pdf';

            $toSave = new Saved();
            $toSave->qid = $name;
            $toSave->subject = $sub;
            $toSave->save();

            if($request['sub']=='dow') return $pdf->download('Questio Paper.pdf');
            return back();
        }
    }
    public function download($id)
    {

        $saved = DB::table('saveds')
            ->where('id',$id)
            ->first();
        $file= 'public/'.$saved->qid;
        $headers = array(
              'Content-Type: application/pdf',
            );
        return response()->download($file, $saved->subject.'.pdf', $headers);
    }
}



/**
   * getRandomWeightedElement()
   * Utility function for getting random values with weighting.
   * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
   * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
   * The return value is the array key, A, B, or C in this case.  Note that the values assigned
   * do not have to be percentages.  The values are simply relative to each other.  If one value
   * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
   * chance of being selected.  Also note that weights should be integers.
   * 
   * @param array $weightedValues
   */
  function getRandomWeightedElement(array $weightedValues) {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
  }