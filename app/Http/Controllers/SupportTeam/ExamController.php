<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Requests\Exam\ExamCreate;
use App\Http\Requests\Exam\ExamUpdate;
use App\Repositories\ExamRepo;
use App\Http\Controllers\Controller;
use App\Repositories\MyClassRepo;
use App\Repositories\StudentRepo;
use App\Repositories\MarkRepo;

class ExamController extends Controller
{
    protected $exam, $my_class, $student, $mark;
    public function __construct(ExamRepo $exam, MyClassRepo $my_class, StudentRepo $student, MarkRepo $mark)
    {
        $this->middleware('teamSA', ['except' => ['destroy',] ]);
        $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->exam = $exam;
        $this->my_class = $my_class;
        $this->student = $student;
        $this->mark = $mark;
    }

    public function index()
    {
        $d['exams'] = $this->exam->all();

        // Fetch the promotion data using the getPromotionData() method from PromotionController
        $gradeController = new GradeController($this->exam, $this->my_class);
        $gradeData = $gradeController->index();

        $markController = new MarkController($this->my_class, $this->exam,  $this->student, $this->mark); // Pass the required repositories
        $tabulationData = $markController->tabulation();
        $batchData = $markController->batch_fix();
        $indexData = $markController->index();
        $bulkData = $markController->bulk();

        // Merge
        $d = array_merge($d, $gradeData, $tabulationData, $batchData, $bulkData);

        return view('pages.support_team.exams.index', $d);
    }

    public function store(ExamCreate $req)
    {
        $data = $req->only(['name', 'term']);
        $data['year'] = Qs::getSetting('current_session');

        $this->exam->create($data);
        return back()->with('flash_success', __('msg.store_ok'));
    }

    public function edit($id)
    {
        $d['ex'] = $this->exam->find($id);
        return view('pages.support_team.exams.edit', $d);
    }

    public function update(ExamUpdate $req, $id)
    {
        $data = $req->only(['name', 'term']);

        $this->exam->update($id, $data);
        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function destroy($id)
    {
        $this->exam->delete($id);
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
