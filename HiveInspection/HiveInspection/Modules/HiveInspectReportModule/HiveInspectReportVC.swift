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
    
    override func viewDidLoad() {
        super.viewDidLoad()
        showColoredNavigationBar(.white)
        closeButton()
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
    
    func loadUrl() {
        if let url = urlToLoad {
            let urlRequest = URLRequest(url: url)
            wkWebViewOutlet.load(urlRequest)
        }
    }
}
