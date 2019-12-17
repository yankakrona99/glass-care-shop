<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Http\Constants\UserRole;

class StaffsController extends Controller
{
    public function __construct(
        User $user,
        Staff $staff
    ) {
        $this->user = $user;
        $this->staff = $staff;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $staffs  = $this->staff->filter($request);
            $genders = UserRole::USER_GANDER_TEXT_EN;
            return view('backends.staffs.index', [
                'request' => $request,
                'staffs' =>  $staffs,
                'genders' => $genders
            ]);
        }catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return view('backends.staffs.create', [
                'request' => $request,
            ]);
        }catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $staffRequest = $request->all();
            if ($request->exists('thumbnail') && !empty($staffRequest['thumbnail'])) {
                $staffRequest['thumbnail'] = uploadFile($staffRequest['thumbnail'], config('upload.staff'));
            }
            $staffRequest['dob'] = date('Y-m-d', strtotime($staffRequest['dob']));
            $this->staff->create($staffRequest);
            return \Redirect::route('staff.index')
                ->with('success',__('flash.store'));
        }catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $id)
    {
        try {
            $staff = $this->staff->available($id);
            if (!$staff) {
                return response()->view('errors.404', [], 404);
            }
            return view('backends.staffs.show', [
                'staff' => $staff,
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        try {
            $staff = $this->staff->available($id);
            if (!$staff) {
                return response()->view('errors.404', [], 404);
            }
            return view('backends.staffs.edit', [
                'request' => $request,
                'staff' => $staff,
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.edit');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $staffRequest = $request->all();
            $staff = $this->staff->available($id);
            if (!$staff) {
                return response()->view('errors.404', [], 404);
            }
            if (!empty($request->thumbnail)) {
                $staffRequest['thumbnail'] = uploadFile($request->thumbnail, config('upload.staff'));
            }
            $staffRequest['dob'] = date('Y-m-d', strtotime($staffRequest['dob']));
            $staff->update($staffRequest);
            return \Redirect::route('staff.index')
                ->with('warning',__('flash.update'));

        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->staff_id;
            $staff = $this->staff->available($id);
            if (!$staff) {
                return response()->view('errors.404', [], 404);
            }
            $staff->remove();
            return redirect()->route('staff.index')
                ->with('danger',__('flash.destroy'));
        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.staffs.index');
        }
    }
}