//
//  HiveListVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 09/09/23.
//

import UIKit
class CellT_HiveList : UITableViewCell {
    @IBOutlet private weak var lblHiveNameOutlet : UILabel!
    @IBOutlet private weak var lblHiveLocationOutlet : UILabel!
    @IBOutlet private weak var lblHiveBuildDateOutlet : UILabel!
    @IBOutlet weak var onBtnExportHiveOutlet : UIButton!
    
    func setDataWith(model : HiveListModelData) {
        self.lblHiveNameOutlet.text = model.hiveName
        self.lblHiveLocationOutlet.text = model.location
        self.lblHiveBuildDateOutlet.text = model.buildDate
    }
}

class HiveListVC: UIViewController {
    
    var hiveListVM : HiveListViewModel?
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet private weak var lblNoDataOutlet : UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        lblNoDataOutlet.isHidden = true
        showColoredNavigationBar(.white)
        self.title = "Hive List"
        addButton()
        tableview.dataSource = self
        tableview.delegate = self
        hiveListVM = HiveListViewModel()
        hiveListVM?.delegate = self
    }
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        hiveListVM?.callAPI()
        addButton()
    }
    
    override func addButtonAction() {
        super.addButtonAction()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
        dvc.showBackbutton = true
        navigationController?.pushViewController(dvc, animated: true)
    }
    
    @IBAction func onBtnExportAction(_ sender: LetsButton) {
        if let hiveId = hiveListVM?.hiveListModel?.data?[sender.tag].hiveid {
            let param : [String:Any] = ["data":["hive_id":hiveId.string]]
            hiveListVM?.callExportHiveAPI(param: param, completion: { response in
                if let data = response?.data, let dataUrl = URL(string: data) {
                    if let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspectReportVC") as? HiveInspectReportVC {
                        dvc.urlToLoad = dataUrl
                        dvc.hiveId = hiveId.string
                        self.navigationController?.pushViewController(dvc, animated: true)
                    }
                }
            })
        }
    }
}

extension HiveListVC : HiveListResponse {
    func getHiveListResponse(_ model: HiveListModel) {
        if (model.status ?? 1) == 1 {
            if (model.data?.count ?? 0) > 0 {
                self.tableview.reloadData()
                lblNoDataOutlet.isHidden = true
            }else {
                lblNoDataOutlet.isHidden = false
//                let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
//                let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
//                navVC.showColoredNavigationBar(.white)
//                appDelegate.window?.switchRootViewController(to: navVC)
            }
        }else if (model.status ?? 0) == 2 {
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
            navVC.showColoredNavigationBar(.white)
            appDelegate.window?.switchRootViewController(to: navVC)
        }else {
            lblNoDataOutlet.isHidden = false
//            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
//            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
//            navVC.showColoredNavigationBar(.white)
//            appDelegate.window?.switchRootViewController(to: navVC)
        }
    }
    
    func deleteHiveResponse(_ model: HiveListDeleteModel) {
        if (model.status ?? 1) == 1 {
            hiveListVM?.callAPI()
        }else if (model.status ?? 0) == 2 {
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
            navVC.showColoredNavigationBar(.white)
            appDelegate.window?.switchRootViewController(to: navVC)
        }
    }
    
    func failureResponse(_ error: String) {
        UIAlertController.actionWith(andMessage: error, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
    }
}

extension HiveListVC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return hiveListVM?.hiveListModel?.data?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveList", for: indexPath) as? CellT_HiveList else { return UITableViewCell() }
        cell.onBtnExportHiveOutlet.tag = indexPath.row
        if let item = hiveListVM?.hiveListModel?.data?[indexPath.row] {
            cell.setDataWith(model: item)
        }
        return cell
    }
    
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return UITableView.automaticDimension
    }
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
        if let item = hiveListVM?.hiveListModel?.data?[indexPath.row] {
            dvc.hiveListModelData = item
        }
        navigationController?.pushViewController(dvc, animated: true)
    }
    
    func tableView(_ tableView: UITableView, commit editingStyle: UITableViewCell.EditingStyle, forRowAt indexPath: IndexPath) {
        if editingStyle == .delete {
            UIAlertController.actionWith(andMessage: "Are you sure you want to delete this hive?", getStyle: .alert, controller: self, buttons: [UIAlertController.actionTitleStyle(title: "Yes", style: .default), UIAlertController.actionTitleStyle(title: "Cancel", style: .cancel)]) { [weak self] btn in
                guard let weakSelf = self else { return }
                if btn == "Yes" {
                    let item = weakSelf.hiveListVM?.hiveListModel?.data?[indexPath.row]
                    let param : [String : Any] = ["data":["hive_id":item?.hiveid?.string ?? ""]]
                    weakSelf.hiveListVM?.callDeleteHiveAPI(param: param)
                }
            }
        }
    }
}

extension HiveListVC {
    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        let dvc : SettingsVC = mainStoryBoard.instantiateViewController(withIdentifier: "SettingsVC") as! SettingsVC
        navigationController?.pushViewController(dvc, animated: true)
    }
}
