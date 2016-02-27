//
//  ListViewController.swift
//  totd
//
//  Created by Bill Snook on 2/26/16.
//  Copyright © 2016 BillSnook. All rights reserved.
//

import Foundation
import UIKit
import CoreData


class ListViewController: UIViewController, UITableViewDataSource {
	
	@IBOutlet weak var tableView: UITableView!

	var people = [NSManagedObject]()
	
	override func viewDidLoad() {
		super.viewDidLoad()

		title = "\"The List\""
		tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "Cell")
}
	
	override func didReceiveMemoryWarning() {
		super.didReceiveMemoryWarning()
		// Dispose of any resources that can be recreated.
	}

	// MARK: UITableViewDataSource
	func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
		return people.count
	}
 
	func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
		
		let cell = tableView.dequeueReusableCellWithIdentifier("Cell")
		
		let person = people[indexPath.row]
		cell!.textLabel!.text = person.valueForKey( "name" ) as? String
		
		return cell!
	}
	

}