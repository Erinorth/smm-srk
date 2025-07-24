<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConfinedSpace;
use App\Models\HoistTesting;
use App\Models\HotWork;
use App\Models\Job;
use App\Models\Lifting;
use App\Models\Observation;
use App\Models\Participation;
use App\Models\Tool;
use App\Models\WorkAtHight;
use App\Models\WorkAtHightWind;
use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Validator;

class UploadFileController extends Controller
{
    public function project(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $projectid = $request->get('project_id');
        $attachmenttype = $request->get('attachment_type');
        $file = $request->file('select_file');
        $attachmentid = $request->get('attachment_id');

        $path = 'project'.$projectid.'/'.$attachmenttype.'/';
        $file_name = $attachmentid.'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');
        if($upload){

            if ( $attachmenttype == 'confinedspace' ) {
                $confinedspace = ConfinedSpace::find($attachmentid);
                $confinedspace->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'check_list' ) {
                $workpermit = Job::find($attachmentid);
                $workpermit->update([
                    'CheckList' => $file_name,
                    'CheckListPath' => $path
                ]);
            }

            if ( $attachmenttype == 'hoist' ) {
                $hoist = HoistTesting::find($attachmentid);
                $hoist->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'hot_work' ) {
                $hotwork = HotWork::find($attachmentid);
                $hotwork->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'lifting' ) {
                $lifting = Lifting::find($attachmentid);
                $lifting->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'observation' ) {
                $observation = Observation::find($attachmentid);
                $observation->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'participation' ) {
                $participation = Participation::find($attachmentid);
                $participation->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'work_at_hight' ) {
                $work_at_hight = WorkAtHight::find($attachmentid);
                $work_at_hight->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'work_at_hight_wind' ) {
                $work_at_hight_wind = WorkAtHightWind::find($attachmentid);
                $work_at_hight_wind->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            if ( $attachmenttype == 'work_permit' ) {
                $workpermit = WorkPermit::find($attachmentid);
                $workpermit->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);
            }

            return response()->json(['success' => 'Upload successfully.']);
        }
    }

    public function projectupdate(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $attachmenttype = $request->get('attachment_type');
        $file = $request->file('select_file');
        $attachmentid = $request->get('attachment_id');

        if ( $attachmenttype == 'confinedspace' ) {
            $confinedspace = ConfinedSpace::find($attachmentid);
            $path = $confinedspace->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$confinedspace->Attachment;
            if ( $confinedspace->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $confinedspace->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'check_list' ) {
            $checklist = Job::find($attachmentid);
            $path = $checklist->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$checklist->CheckList;
            if ( $checklist->CheckList != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $checklist->update([
                'CheckList' => $file_name
            ]);
        }

        if ( $attachmenttype == 'hoist' ) {
            $hoist = HoistTesting::find($attachmentid);
            $path = $hoist->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$hoist->Attachment;
            if ( $hoist->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $hoist->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'hot_work' ) {
            $hotwork = HotWork::find($attachmentid);
            $path = $hotwork->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$hotwork->Attachment;
            if ( $hotwork->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $hotwork->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'lifting' ) {
            $lifting = Lifting::find($attachmentid);
            $path = $lifting->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$lifting->Attachment;
            if ( $lifting->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $lifting->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'observation' ) {
            $observation = Observation::find($attachmentid);
            $path = $observation->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$observation->Attachment;
            if ( $observation->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $observation->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'participation' ) {
            $participation = Participation::find($attachmentid);
            $path = $participation->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$participation->Attachment;
            if ( $participation->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $participation->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'work_at_hight' ) {
            $work_at_hight = WorkAtHight::find($attachmentid);
            $path = $work_at_hight->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$work_at_hight->Attachment;
            if ( $work_at_hight->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $work_at_hight->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'work_at_hight_wind' ) {
            $work_at_hight_wind = WorkAtHightWind::find($attachmentid);
            $path = $work_at_hight_wind->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$work_at_hight_wind->Attachment;
            if ( $work_at_hight_wind->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $work_at_hight_wind->update([
                'Attachment' => $file_name
            ]);
        }

        if ( $attachmenttype == 'work_permit' ) {
            $workpermit = WorkPermit::find($attachmentid);
            $path = $workpermit->AttachmentPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$workpermit->Attachment;
            if ( $workpermit->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $workpermit->update([
                'Attachment' => $file_name
            ]);
        }

        return response()->json(['success' => 'Update successfully.']);
    }

    public function projectdelete($id,$type)
    {
        if ( $type == 'confinedspace' ) {
            $confinedspace = ConfinedSpace::find($id);
            $path = $confinedspace->AttachmentPath;
            $file_path = $path.$confinedspace->Attachment;
            if ( $confinedspace->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $confinedspace->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'check_list' ) {
            $checklist = Job::find($id);
            $path = $checklist->AttachmentPath;
            $file_path = $path.$checklist->CheckList;
            if ( $checklist->CheckList != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $checklist->update([
                'CheckList' => null,
                'CheckListPath' => null
            ]);
        }

        if ( $type == 'hoist' ) {
            $hoist = HoistTesting::find($id);
            $path = $hoist->AttachmentPath;
            $file_path = $path.$hoist->Attachment;
            if ( $hoist->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $hoist->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'hot_work' ) {
            $hotwork = HotWork::find($id);
            $path = $hotwork->AttachmentPath;
            $file_path = $path.$hotwork->Attachment;
            if ( $hotwork->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $hotwork->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'lifting' ) {
            $lifting = Lifting::find($id);
            $path = $lifting->AttachmentPath;
            $file_path = $path.$lifting->Attachment;
            if ( $lifting->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $lifting->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'observation' ) {
            $observation = Observation::find($id);
            $path = $observation->AttachmentPath;
            $file_path = $path.$observation->Attachment;
            if ( $observation->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $observation->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'participation' ) {
            $participation = Participation::find($id);
            $path = $participation->AttachmentPath;
            $file_path = $path.$participation->Attachment;
            if ( $participation->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $participation->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'work_at_hight' ) {
            $work_at_hight = WorkAtHight::find($id);
            $path = $work_at_hight->AttachmentPath;
            $file_path = $path.$work_at_hight->Attachment;
            if ( $work_at_hight->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $work_at_hight->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'work_at_hight_wind' ) {
            $work_at_hight_wind = WorkAtHightWind::find($id);
            $path = $work_at_hight_wind->AttachmentPath;
            $file_path = $path.$work_at_hight_wind->Attachment;
            if ( $work_at_hight_wind->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $work_at_hight_wind->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }

        if ( $type == 'work_permit' ) {
            $workpermit = WorkPermit::find($id);
            $path = $workpermit->AttachmentPath;
            $file_path = $path.$workpermit->Attachment;
            if ( $workpermit->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $workpermit->update([
                'Attachment' => null,
                'AttachmentPath' => null
            ]);
        }
    }

    public function tool(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $attachmenttype = $request->get('attachment_type');
        $file = $request->file('select_file');
        $attachmentid = $request->get('attachment_id');

        $path = 'tool'.$attachmentid.'/'.$attachmenttype.'/';
        $file_name = $attachmentid.'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');
        if($upload){

            if ( $attachmenttype == 'accepted' ) {
                $accepted = Tool::find($attachmentid);
                $accepted->update([
                    'Accepted' => $file_name,
                    'AcceptedPath' => $path
                ]);
            }

            return response()->json(['success' => 'Upload successfully.']);
        }
    }

    public function toolupdate(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $attachmenttype = $request->get('attachment_type');
        $file = $request->file('select_file');
        $attachmentid = $request->get('attachment_id');

        if ( $attachmenttype == 'accepted' ) {
            $accepted = Tool::find($attachmentid);
            $path = $accepted->AcceptedPath;
            $file_name = $attachmentid.'-'.$file->getClientOriginalName();
            $update = $file->storeAs($path, $file_name, 'public');
            $file_path = $path.$accepted->Accepted;
            if ( $accepted->Accepted != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $accepted->update([
                'Accepted' => $file_name
            ]);
        }

        return response()->json(['success' => 'Update successfully.']);
    }

    public function tooldelete($id,$type)
    {
        if ( $type == 'accepted' ) {
            $accepted = Tool::find($id);
            $path = $accepted->AcceptedPath;
            $file_path = $path.$accepted->Accepted;
            if ( $accepted->Accepted != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $accepted->update([
                'Accepted' => null,
                'AcceptedPath' => null
            ]);
        }
    }
}
