<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Panel;

class task extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\task>
     */
    public static $model = \App\Models\task::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // ── สรุปงาน (เหมือน header กล่องสีเขียวในภาพ) ─────────────────────────────
            Panel::make('สรุป', [
                Text::make('Issue', 'issue'),
                Text::make('Task', 'task'),
                Text::make('โครงการ', 'project')->onlyOnDetail(),

                // สถานะเป็น Badge สีให้ใกล้เคียงกับปุ่มเขียว "เสร็จสิ้น"
                Badge::make('สถานะ', 'status')
                    ->map([
                        'เสร็จสิ้น' => 'success',
                        'กำลังดำเนินการ' => 'info',
                        'รอดำเนินการ' => 'warning',
                    ])
                    ->exceptOnForms(),
            ])->withToolbar(),


            // ── รายละเอียดงาน ─────────────────────────────────────────────────────────
            Panel::make('รายละเอียดงาน', [
                Select::make('ประเภทงาน', 'types')
                    ->options([
                        'พัฒนา' => 'พัฒนา',
                        'ทดสอบ' => 'ทดสอบ',
                        'วิเคราะห์ระบบ' => 'วิเคราะห์ระบบ',
                        'ดูแลระบบ' => 'ดูแลระบบ',
                    ])
                    ->onlyOnDetail()
                    ->displayUsingLabels()
                    ->filterable(),

                Select::make('สถานะ', 'status')
                    ->options([
                        'เสร็จสิ้น' => 'เสร็จสิ้น',
                        'กำลังทำ' => 'กำลังทำ',
                        'รอดำเนินการ' => 'รอดำเนินการ',
                    ])
                    ->displayUsingLabels()
                    ->onlyOnForms(),

                Date::make('วันเริ่มทำงาน', 'start_date')
                    ->displayUsing(function ($value) {
                        if (!$value) return null;
                        return \Carbon\Carbon::parse($value)->format('d/m/Y');
                    }),

                Date::make('วันกำหนดส่ง', 'end_date')
                    ->displayUsing(function ($value) {
                        if (!$value) return null;
                        return \Carbon\Carbon::parse($value)->format('d/m/Y');
                    }),

                Text::make('ผู้รับผิดชอบ', 'author'),
                Textarea::make('หมายเหตุ', 'remark')->alwaysShow(),
            ])->withToolbar(),

            // ── การตรวจสอบคุณภาพ (ส่วนล่างในภาพ) ──────────────────────────────────────
            Panel::make('การตรวจสอบคุณภาพ', [
                Text::make('รอบทดสอบ', 'testRound')->onlyOnDetail(),
                Text::make('ผู้ตรวจสอบ', 'tester')->onlyOnDetail()
            ])->withToolbar(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}