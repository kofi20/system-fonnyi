@extends('layouts.master')
@section('page_title', 'Manage Exams')
@section('content')

    <div class="exams">
        <h1>Payments</h1>
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#exams" class="nav-link active" data-toggle="tab">Exam List</a></li>
            <li class="nav-item"><a href="#grades" class="nav-link" data-toggle="tab">Grades</a></li>
            <li class="nav-item"><a href="#sheet" class="nav-link" data-toggle="tab">Tabulation Sheet</a></li>
            <li class="nav-item"><a href="#fix" class="nav-link" data-toggle="tab">Batch Fix</a></li>
            <li class="nav-item"><a href="#mark" class="nav-link" data-toggle="tab">Marks</a></li>
            <li class="nav-item"><a href="#ms" class="nav-link" data-toggle="tab">MarkSheet</a></li>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="exams">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Manage Exams</h6>
                        {!! Qs::getPanelOptions() !!}
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            <li class="nav-item"><a href="#all-exams" class="nav-link active" data-toggle="tab">Manage
                                    Exam</a></li>
                            <li class="nav-item"><a href="#new-exam" class="nav-link" data-toggle="tab"><i
                                        class="icon-plus2"></i> Add Exam</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="all-exams">
                                <table class="table datatable-button-html5-columns">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Term</th>
                                            <th>Session</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exams as $ex)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ex->name }}</td>
                                                <td>{{ 'Term ' . $ex->term }}</td>
                                                <td>{{ $ex->year }}</td>
                                                <td class="text-center">
                                                    <div class="list-icons">
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item"
                                                                data-toggle="dropdown">
                                                                <i class="icon-menu9"></i>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-left">
                                                                @if (Qs::userIsTeamSA())
                                                                    {{-- Edit --}}
                                                                    <a href="{{ route('exams.edit', $ex->id) }}"
                                                                        class="dropdown-item"><i class="icon-pencil"></i>
                                                                        Edit</a>
                                                                @endif
                                                                @if (Qs::userIsSuperAdmin())
                                                                    {{-- Delete --}}
                                                                    <a id="{{ $ex->id }}"
                                                                        onclick="confirmDelete(this.id)" href="#"
                                                                        class="dropdown-item"><i class="icon-trash"></i>
                                                                        Delete</a>
                                                                    <form method="post"
                                                                        id="item-delete-{{ $ex->id }}"
                                                                        action="{{ route('exams.destroy', $ex->id) }}"
                                                                        class="hidden">@csrf @method('delete')</form>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="new-exam">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info border-0 alert-dismissible">
                                            <button type="button" class="close"
                                                data-dismiss="alert"><span>&times;</span></button>

                                            <span>You are creating an Exam for the Current Session
                                                <strong>{{ Qs::getSetting('current_session') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="post" action="{{ route('exams.store') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label font-weight-semibold">Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input name="name" value="{{ old('name') }}" required
                                                        type="text" class="form-control" placeholder="Name of Exam">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="term"
                                                    class="col-lg-3 col-form-label font-weight-semibold">Term</label>
                                                <div class="col-lg-9">
                                                    <select data-placeholder="Select Teacher"
                                                        class="form-control select-search" name="term" id="term">
                                                        <option {{ old('term') == 1 ? 'selected' : '' }} value="1">
                                                            First Term</option>
                                                        <option {{ old('term') == 2 ? 'selected' : '' }} value="2">
                                                            Second Term</option>
                                                        <option {{ old('term') == 3 ? 'selected' : '' }} value="3">
                                                            Third Term</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Submit form <i
                                                        class="icon-paperplane ml-2"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- grades --}}
            <div class="tab-pane fade" id="grades">
                @include('pages.support_team.grades.index')
            </div>

            {{-- Tabulation Sheet --}}
            <div class="tab-pane fade" id="sheet">
                @include('pages.support_team.marks.tabulation.index')
            </div>

            {{-- Batch Fix --}}
            <div class="tab-pane fade" id="fix">
                @include('pages.support_team.marks.batch_fix')
            </div>

            {{-- Marks  --}}
            <div class="tab-pane fade" id="mark">
                @include('pages.support_team.marks.index')
            </div>

            {{-- MarkSheet  --}}
            <div class="tab-pane fade" id="ms">
                @include('pages.support_team.marks.bulk')
            </div>
        </div>


    </div>

    {{-- Class List Ends --}}

@endsection
