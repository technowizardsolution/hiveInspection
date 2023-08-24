//
//  ImageAssetName.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 24/08/23.
//

import UIKit

enum ImageAsset : String {
    case hiveImage = "ic_hive"
    case hiveHexPattern = "ic_hexPattern"
    
    func imageFrom(asset : Self) -> UIImage {
        guard let image = UIImage(named: asset.rawValue) else { return UIImage() }
        return image
    }
}
