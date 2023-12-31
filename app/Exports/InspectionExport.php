<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Helper\GlobalHelper;
use App\Inspection;

class InspectionExport implements FromCollection,WithMapping, WithHeadings, WithEvents
{
  
    use Exportable;

    public function __construct($hive_id)
    {
        $this->hive_id = $hive_id;   
        $this->green = '008000';   
        $this->red = 'FF0000';   
        $this->yellow = 'F4B61A';        
        $this->gray = 'adabab';        
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
         
        return ['Inspection Date','Normal Hive Condition', 'Saw Queen','Queen marked','Eggs seen', 'Larva seen','Pupa seen', 'Drone cells', 'Queen cells','Hive beetles','Wax moth','Nosema','Mite wash','Mite count','Temperment','Population', 'Solid uniform frames','Slightly potty frames','Spotty frames','Normal odor','Brood','Honey','Pollen','Frames of bees','Frames of brood','Frames of honey','Frames of pollen','Honey supers','Add supers','Weigh super 3','Weigh super 2','Weigh super 1','Weigh brood 3','Weigh brood 2','Weigh brood 1','Prep for extraction','Feed hive what','Medication Reminder','Install medication what','Remove medication','Split hive','Re queen','Swap brood boxes','Insulate winterize','Additional notes'];        
    }

    public function collection()
    {
      
        // DB::enableQueryLog();
        $inspection = Inspection::where('hive_id',$this->hive_id)->get();
        return $inspection;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $inspections = Inspection::where('hive_id',$this->hive_id)->get();
                foreach($inspections as $key => $inspection) {
                    if($inspection->normal_hive_condition==1) {
                        $event->sheet->getDelegate()->getStyle('B'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('B'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->saw_queen==1) {
                        $event->sheet->getDelegate()->getStyle('c'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('c'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->queen_marked==1) {
                        $event->sheet->getDelegate()->getStyle('D'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('D'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->eggs_seen==1) {
                        $event->sheet->getDelegate()->getStyle('E'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('E'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->larva_seen==1) {
                        $event->sheet->getDelegate()->getStyle('F'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('F'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->pupa_seen==1) {
                        $event->sheet->getDelegate()->getStyle('G'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('G'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->drone_cells==1) {
                        $event->sheet->getDelegate()->getStyle('H'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('H'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->queen_cells==1) {
                        $event->sheet->getDelegate()->getStyle('I'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else {
                        $event->sheet->getDelegate()->getStyle('I'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->green);
                    }

                    if($inspection->hive_beetles==1) {
                        $event->sheet->getDelegate()->getStyle('J'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->red);
                    } else {
                        $event->sheet->getDelegate()->getStyle('J'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->green);
                    }

                    if($inspection->wax_moth==1) {
                        $event->sheet->getDelegate()->getStyle('K'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->red);
                    } else {
                        $event->sheet->getDelegate()->getStyle('K'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->green);
                    }

                    if($inspection->noseema==1) {
                        $event->sheet->getDelegate()->getStyle('L'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->red);
                    } else {
                        $event->sheet->getDelegate()->getStyle('L'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->green);
                    }

                    if($inspection->mite_wash==1) {
                        $event->sheet->getDelegate()->getStyle('M'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('M'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->temperment == 'Calm') {
                        $event->sheet->getDelegate()->getStyle('O'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else if($inspection->temperment == 'Nervous') {
                        $event->sheet->getDelegate()->getStyle('O'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else {
                        $event->sheet->getDelegate()->getStyle('O'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->population == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('P'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else if($inspection->population == 'Moderate') {
                        $event->sheet->getDelegate()->getStyle('P'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('P'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->spotty_frames) {
                        $event->sheet->getDelegate()->getStyle('S'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->red);                        
                    } else {
                        $event->sheet->getDelegate()->getStyle('S'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->green);                        
                    }

                    if($inspection->normal_odor==1) {
                        $event->sheet->getDelegate()->getStyle('T'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('T'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->brood == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('U'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else if($inspection->brood == 'Moderate') {
                        $event->sheet->getDelegate()->getStyle('U'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('U'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->honey == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('V'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else if($inspection->honey == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('V'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->gray);
                    } else {
                        $event->sheet->getDelegate()->getStyle('V'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->pollen == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('W'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else if($inspection->pollen == 'Heavy') {
                        $event->sheet->getDelegate()->getStyle('W'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('W'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->red);
                    }

                    if($inspection->honey_supers) {
                        $event->sheet->getDelegate()->getStyle('AB'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AB'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->add_supers) {
                        $event->sheet->getDelegate()->getStyle('AC'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AC'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_super_3) {
                        $event->sheet->getDelegate()->getStyle('AD'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AD'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_super_2) {
                        $event->sheet->getDelegate()->getStyle('AE'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AE'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_super_1) {
                        $event->sheet->getDelegate()->getStyle('AF'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AF'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_brood_3) {
                        $event->sheet->getDelegate()->getStyle('AG'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AG'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_brood_2) {
                        $event->sheet->getDelegate()->getStyle('AH'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AH'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->weigh_brood_1) {
                        $event->sheet->getDelegate()->getStyle('AI'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AI'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->prep_for_extraction ==1) {
                        $event->sheet->getDelegate()->getStyle('AJ'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AJ'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->install_medication_what == 'Formic') {
                        $event->sheet->getDelegate()->getStyle('AM'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else if($inspection->install_medication_what == 'Apivar') {
                        $event->sheet->getDelegate()->getStyle('AM'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AM'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->remove_medication ==1) {
                        $event->sheet->getDelegate()->getStyle('AN'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AN'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->yellow);
                    }

                    if($inspection->split_hive ==1) {
                        $event->sheet->getDelegate()->getStyle('AO'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->yellow);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AO'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->re_queen ==1) {
                        $event->sheet->getDelegate()->getStyle('AP'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->green);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AP'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->swap_brood_boxes ==1) {
                        $event->sheet->getDelegate()->getStyle('AQ'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->gray);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AQ'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }

                    if($inspection->insulate_winterize ==1) {
                        $event->sheet->getDelegate()->getStyle('AR'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($this->gray);
                    } else {
                        $event->sheet->getDelegate()->getStyle('AR'.(string)($key+2))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($this->gray);
                    }
                }
            },
        ];
    }

    public function map($inspection): array
    {
        if($inspection->normal_hive_condition==1){ $normal_hive_condition='Yes'; }else{ $normal_hive_condition='No'; }
        if($inspection->saw_queen==1){ $saw_queen='Yes'; }else{ $saw_queen='No'; }
        if($inspection->queen_marked==1){ $queen_marked='Yes'; }else{ $queen_marked='No'; }
        if($inspection->eggs_seen==1){ $eggs_seen='Yes'; }else{ $eggs_seen='No'; }
        if($inspection->larva_seen==1){ $larva_seen='Yes'; }else{ $larva_seen='No'; }
        if($inspection->pupa_seen==1){ $pupa_seen='Yes'; }else{ $pupa_seen='No'; }
        if($inspection->drone_cells==1){ $drone_cells='Yes'; }else{ $drone_cells='No'; }
        if($inspection->queen_cells==1){ $queen_cells='Yes'; }else{ $queen_cells='No'; }
        if($inspection->hive_beetles==1){ $hive_beetles='Yes'; }else{ $hive_beetles='No'; }
        if($inspection->wax_moth==1){ $wax_moth='Yes'; }else{ $wax_moth='No'; }
        if($inspection->noseema==1){ $noseema='Yes'; }else{ $noseema='No'; }
        if($inspection->mite_wash==1){ $mite_wash='Yes'; }else{ $mite_wash='No'; }
        if($inspection->solid_uniform_frames){ $solid_uniform_frames=$inspection->solid_uniform_frames; }else{ $solid_uniform_frames='No'; }
        if($inspection->slightly_spotty_frames){ $slightly_spotty_frames=$inspection->slightly_spotty_frames; }else{ $slightly_spotty_frames='No'; }
        if($inspection->spotty_frames){ $spotty_frames=$inspection->spotty_frames; }else{ $spotty_frames='No'; }        
        if($inspection->normal_odor==1){ $normal_odor='Yes'; }else{ $normal_odor='No'; }
        if($inspection->honey_supers){ $honey_supers = $inspection->honey_supers; }else{ $honey_supers='No'; }
        if($inspection->add_supers){ $add_supers = $inspection->add_supers; }else{ $add_supers='No'; }
        if($inspection->weigh_super_3){ $weigh_super_3 = $inspection->weigh_super_3; }else{ $weigh_super_3='No'; }
        if($inspection->weigh_super_2){ $weigh_super_2 = $inspection->weigh_super_2; }else{ $weigh_super_2='No'; }
        if($inspection->weigh_super_1){ $weigh_super_1 = $inspection->weigh_super_1; }else{ $weigh_super_1='No'; }
        if($inspection->weigh_brood_3){ $weigh_brood_3 = $inspection->weigh_brood_3; }else{ $weigh_brood_3='No'; }
        if($inspection->weigh_brood_2){ $weigh_brood_2 = $inspection->weigh_brood_2; }else{ $weigh_brood_2='No'; }
        if($inspection->weigh_brood_1){ $weigh_brood_1 = $inspection->weigh_brood_1; }else{ $weigh_brood_1='No'; }
        if($inspection->prep_for_extraction==1){ $prep_for_extraction='Yes'; }else{ $prep_for_extraction='No'; }
        if($inspection->feed_hive_what){ $feed_hive_what = $inspection->feed_hive_what; }else{ $feed_hive_what='-'; }
        if($inspection->install_medication_what){ $install_medication_what = $inspection->install_medication_what; }else{ $install_medication_what='-'; }
        if($inspection->remove_medication==1){ $remove_medication='Yes'; }else{ $remove_medication='No'; }
        if($inspection->split_hive==1){ $split_hive='Yes'; }else{ $split_hive='No'; }
        if($inspection->re_queen==1){ $re_queen='Yes'; }else{ $re_queen='No'; }
        if($inspection->swap_brood_boxes==1){ $swap_brood_boxes='Yes'; }else{ $swap_brood_boxes='No'; }
        if($inspection->insulate_winterize==1){ $insulate_winterize='Yes'; }else{ $insulate_winterize='No'; }
        

        return [
            date("Y-m-d ", strtotime($inspection->inspection_date)),
            $normal_hive_condition,
            $saw_queen,
            $queen_marked,
            $eggs_seen,
            $larva_seen,
            $pupa_seen,
            $drone_cells,
            $queen_cells,
            $hive_beetles,
            $wax_moth,
            $noseema,
            $mite_wash,
            $inspection->mite_count,
            $inspection->temperment,
            $inspection->population,
            $solid_uniform_frames,
            $slightly_spotty_frames,
            $spotty_frames,
            $normal_odor,
            $inspection->brood,
            $inspection->honey,
            $inspection->pollen,
            $inspection->frames_of_bees,
            $inspection->frames_of_brood,
            $inspection->frames_of_honey,
            $inspection->frames_of_pollen,
            $honey_supers,
            $add_supers,
            $weigh_super_3,
            $weigh_super_2,
            $weigh_super_1,
            $weigh_brood_3,
            $weigh_brood_2,
            $weigh_brood_1,
            $prep_for_extraction,
            $feed_hive_what,
            $inspection->medication_reminder,
            $install_medication_what,            
            $remove_medication,
            $split_hive,
            $re_queen,
            $swap_brood_boxes,
            $insulate_winterize,
            $inspection->additional_notes
        ];
    }
}
