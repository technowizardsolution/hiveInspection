//
//  HiveInspectReportVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 25/09/23.
//
import UIKit
import WebKit

class HiveInspectReportVC : UIViewController {
    @IBOutlet weak var wkWebViewOutlet : WKWebView!
    var urlToLoad : URL?
    var hiveId : String?
    
    override func viewDidLoad() {
        super.viewDidLoad()
        showColoredNavigationBar(.white)
        closeButton()
//        exportButton()
        self.title = "Report"
        loadUrl()
    }
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showColoredNavigationBar(.white)
        self.title = "Report"
        closeButton()
        loadUrl()
    }
    
    override func exportButtonAction() {
        super.exportButtonAction()
        if let url = urlToLoad {
            if UIApplication.shared.canOpenURL(url) {
                UIApplication.shared.open(url)
            }
        }
    }
    
    func loadUrl() {
        if let getUrl = URL(string: "\(Constants.baseURL.baseUrlWithoutApi)/inspectionReport/\((hiveId ?? "").base64String)?app=true") {
            let urlRequest = URLRequest(url: getUrl)
            wkWebViewOutlet.load(urlRequest)
        }
    }
}
