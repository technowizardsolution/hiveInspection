//
//  HiveInspectionModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 12/09/23.
//

import Foundation

// MARK: - HiveInspectModel
struct HiveInspectModel: Codable {
    let status: Int?
    let message: String?
//    let data: HiveInspectModelData?

    enum CodingKeys: String, CodingKey {
        case status = "status"
        case message = "message"
//        case data = "data"
    }
}

// MARK: - HiveInspectData
struct HiveInspectModelData: Codable {
    let hiveid: String?
    let userid: Int?
    let inspectionDate: String?
    let normalHiveCondition: String?
    let sawQueen: String?
    let queenMarked: String?
    let eggsSeen: String?
    let larvaSeen: String?
    let pupaSeen: String?
    let droneCells: Int?
    let queenCells: Int?
    let hiveBeetles: Int?
    let waxMoth: Int?
    let noseema: Int?
    let miteWash: Int?
    let miteCount: Int?
    let temperment: Int?
    let population: Int?
    let solidUniformFrames: Int?
    let slightlySpottyFrames: Int?
    let spottyFrames: Int?
    let normalOdor: Int?
    let brood: Int?
    let honey: Int?
    let pollen: Int?
    let framesOfBees: Int?
    let framesOfBrood: Int?
    let framesOfHoney: Int?
    let framesOfPollen: Int?
    let honeySupers: Int?
    let addSupers: Int?
    let weighSuper3: Int?
    let weighSuper2: Int?
    let weighSuper1: Int?
    let weighBrood3: Int?
    let weighBrood2: Int?
    let weighBrood1: Int?
    let prepForExtraction: Int?
    let feedHiveWhat: Int?
    let installMedicationWhat: String?
    let medicationReminder: String?
    let removeMedication: Int?
    let splitHive: Int?
    let reQueen: Int?
    let swapBroodBoxes: Int?
    let insulateWinterize: Int?
    let additionalNotes: String?
    let updatedAt: String?
    let createdAt: String?
    let inspectionid: Int?

    enum CodingKeys: String, CodingKey {
        case hiveid = "hive_id"
        case userid = "user_id"
        case inspectionDate = "inspection_date"
        case normalHiveCondition = "normal_hive_condition"
        case sawQueen = "saw_queen"
        case queenMarked = "queen_marked"
        case eggsSeen = "eggs_seen"
        case larvaSeen = "larva_seen"
        case pupaSeen = "pupa_seen"
        case droneCells = "drone_cells"
        case queenCells = "queen_cells"
        case hiveBeetles = "hive_beetles"
        case waxMoth = "wax_moth"
        case noseema = "noseema"
        case miteWash = "mite_wash"
        case miteCount = "mite_count"
        case temperment = "temperment"
        case population = "population"
        case solidUniformFrames = "solid_uniform_frames"
        case slightlySpottyFrames = "slightly_spotty_frames"
        case spottyFrames = "spotty_frames"
        case normalOdor = "normal_odor"
        case brood = "brood"
        case honey = "honey"
        case pollen = "pollen"
        case framesOfBees = "frames_of_bees"
        case framesOfBrood = "frames_of_brood"
        case framesOfHoney = "frames_of_honey"
        case framesOfPollen = "frames_of_pollen"
        case honeySupers = "honey_supers"
        case addSupers = "add_supers"
        case weighSuper3 = "weigh_super_3"
        case weighSuper2 = "weigh_super_2"
        case weighSuper1 = "weigh_super_1"
        case weighBrood3 = "weigh_brood_3"
        case weighBrood2 = "weigh_brood_2"
        case weighBrood1 = "weigh_brood_1"
        case prepForExtraction = "prep_for_extraction"
        case feedHiveWhat = "feed_hive_what"
        case installMedicationWhat = "install_medication_what"
        case medicationReminder = "medication_reminder"
        case removeMedication = "remove_medication"
        case splitHive = "split_hive"
        case reQueen = "re_queen"
        case swapBroodBoxes = "swap_brood_boxes"
        case insulateWinterize = "insulate_winterize"
        case additionalNotes = "additional_notes"
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case inspectionid = "inspection_id"
    }
}
