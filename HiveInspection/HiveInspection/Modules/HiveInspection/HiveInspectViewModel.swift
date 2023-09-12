//
//  HiveInspectViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 12/09/23.
//

import Foundation
import SVProgressHUD

protocol HiveInspectResponse {
    func getHiveInspectResponse(_ model : HiveInspectModel)
    func failureResponse(_ error : String)
}

class HiveInspectViewModel : NSObject {
    var hiveListModel : HiveInspectModel?
    var delegate : HiveInspectResponse?
    
    override init() {
        super.init()
    }
}

extension HiveInspectViewModel {
    func callAPI(with model : [HiveInspectData], hiveId : String, additionalNotes : String) {
        SVProgressHUD.show(withStatus: "Please wait")
        let inspectionDate = model.filter({$0.title == "Date"}).first?.selectedTitle
        let NormalHiveCondition = model.filter({$0.title == "Normal Hive Condition"}).first?.selectedTitle
        let SawQueen = model.filter({$0.title == "Saw Queen"}).first?.selectedTitle
        let QueenMarked = model.filter({$0.title == "Queen Marked"}).first?.selectedTitle
        let EggsSeen = model.filter({$0.title == "Eggs Seen"}).first?.selectedTitle
        let LarvaSeen = model.filter({$0.title == "Larva Seen"}).first?.selectedTitle
        let PupaSeen = model.filter({$0.title == "Pupa Seen"}).first?.selectedTitle
        let DroneCells = model.filter({$0.title == "Drone Cells"}).first?.selectedTitle
        let QueenCells = model.filter({$0.title == "Queen Cells"}).first?.selectedTitle
        let HiveBeetles = model.filter({$0.title == "Hive Beetles"}).first?.selectedTitle
        let WaxMoth = model.filter({$0.title == "Wax Moth"}).first?.selectedTitle
        let Noseema = model.filter({$0.title == "Noseema"}).first?.selectedTitle
        let MiteWash = model.filter({$0.title == "Mite Wash"}).first?.selectedTitle
        let MiteCount = model.filter({$0.title == "Mite Count"}).first?.selectedTitle
        let Temperment = model.filter({$0.title == "Temperment"}).first?.selectedTitle
        let Population = model.filter({$0.title == "Population"}).first?.selectedTitle
        let SolidUniformframes = model.filter({$0.title == "Solid & Uniform frames"}).first?.selectedTitle
        let SlightlySpottyframes = model.filter({$0.title == "Slightly Spotty frames"}).first?.selectedTitle
        let Spottyframes = model.filter({$0.title == "Spotty frames"}).first?.selectedTitle
        let NormalOdor = model.filter({$0.title == "Normal Odor"}).first?.selectedTitle
        let Brood = model.filter({$0.title == "Brood"}).first?.selectedTitle
        let Honey = model.filter({$0.title == "Honey"}).first?.selectedTitle
        let Pollen = model.filter({$0.title == "Pollen"}).first?.selectedTitle
        let FramesofBees = model.filter({$0.title == "Frames of Bees"}).first?.selectedTitle
        let FramesofBrood = model.filter({$0.title == "Frames of Brood"}).first?.selectedTitle
        let FramesofHoney = model.filter({$0.title == "Frames of Honey"}).first?.selectedTitle
        let FramesofPollen = model.filter({$0.title == "Frames of Pollen"}).first?.selectedTitle
        let HoneySupers = model.filter({$0.title == "Honey Supers"}).first?.selectedTitle
        let AddSupers = model.filter({$0.title == "Add Supers"}).first?.selectedTitle
        let WeighSuper3 = model.filter({$0.title == "Weigh Super 3"}).first?.selectedTitle
        let WeighSuper2 = model.filter({$0.title == "Weigh Super 2"}).first?.selectedTitle
        let WeighSuper1 = model.filter({$0.title == "Weigh Super 1"}).first?.selectedTitle
        let WeighBrood3 = model.filter({$0.title == "Weigh Brood 3"}).first?.selectedTitle
        let WeighBrood2 = model.filter({$0.title == "Weigh Brood 2"}).first?.selectedTitle
        let WeighBrood1 = model.filter({$0.title == "Weigh Brood 1"}).first?.selectedTitle
        let Prepforextraction = model.filter({$0.title == "Prep for extraction"}).first?.selectedTitle
        let FeedHiveWhat = model.filter({$0.title == "Feed Hive What?"}).first?.selectedTitle
        let InstallMedicationWhat = model.filter({$0.title == "Install Medication What?"}).first?.selectedTitle
        let MedicationReminder = model.filter({$0.title == "Medication Reminder"}).first?.selectedTitle
        let RemoveMedicationSwitch = model.filter({$0.title == "Remove Medication"}).first?.isSwitchWithTextOn
        let SplitHive = model.filter({$0.title == "Split Hive"}).first?.selectedTitle
        let ReQueen = model.filter({$0.title == "Re Queen"}).first?.selectedTitle
        let SwapBroodBoxes = model.filter({$0.title == "Swap Brood Boxes"}).first?.selectedTitle
        let InsulateWinterize = model.filter({$0.title == "Insulate / Winterize"}).first?.selectedTitle
        
        let param : [String : Any] = ["data":
                                        [
                                            "hive_id":hiveId,
                                            "inspection_date": inspectionDate,
                                            "normal_hive_condition":NormalHiveCondition,
                                            "saw_queen":SawQueen,
                                            "queen_marked":QueenMarked,
                                            "eggs_seen":EggsSeen,
                                            "larva_seen":LarvaSeen,
                                            "pupa_seen":PupaSeen,
                                            "drone_cells":DroneCells,
                                            "queen_cells":QueenCells,
                                            "hive_beetles":HiveBeetles,
                                            "wax_moth":WaxMoth,
                                            "noseema":Noseema,
                                            "mite_wash":MiteWash,
                                            "mite_count":MiteCount,
                                            "temperment":Temperment,
                                            "population":Population,
                                            "solid_uniform_frames":SolidUniformframes,
                                            "slightly_spotty_frames":SlightlySpottyframes,
                                            "spotty_frames":Spottyframes,
                                            "normal_odor":NormalOdor,
                                            "brood":Brood,
                                            "honey":Honey,
                                            "pollen":Pollen,
                                            "frames_of_bees":FramesofBees,
                                            "frames_of_brood":FramesofBrood,
                                            "frames_of_honey":FramesofHoney,
                                            "frames_of_pollen":FramesofPollen,
                                            "honey_supers":HoneySupers,
                                            "add_supers":AddSupers,
                                            "weigh_super_3":WeighSuper3,
                                            "weigh_super_2":WeighSuper2,
                                            "weigh_super_1":WeighSuper1,
                                            "weigh_brood_3":WeighBrood3,
                                            "weigh_brood_2":WeighBrood2,
                                            "weigh_brood_1":WeighBrood1,
                                            "prep_for_extraction":Prepforextraction,
                                            "feed_hive_what":FeedHiveWhat,
                                            "install_medication_what":InstallMedicationWhat,
                                            "medication_reminder":MedicationReminder,
                                            "remove_medication":(RemoveMedicationSwitch ?? false) ? "1" : "0",
                                            "split_hive":SplitHive,
                                            "re_queen":ReQueen,
                                            "swap_brood_boxes":SwapBroodBoxes,
                                            "insulate_winterize":InsulateWinterize,
                                            "additional_notes":"note"
                                        ]]
        APIHandler.shared.networkManager.addInspection(param) { [weak self] _result in
            SVProgressHUD.dismiss()
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let response):
                weakSelf.hiveListModel = response
                weakSelf.delegate?.getHiveInspectResponse(response)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
