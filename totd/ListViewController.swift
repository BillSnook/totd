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

	var jokes = [NSManagedObject]()
	
	
	override func viewDidLoad() {
		super.viewDidLoad()

		title = "Joke List"
		tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "Cell")
	}
	
	override func viewWillAppear(animated: Bool) {
		super.viewWillAppear(animated)
		
		let appDelegate = UIApplication.sharedApplication().delegate as! AppDelegate
		let managedContext = appDelegate.managedObjectContext
		let fetchRequest = NSFetchRequest(entityName: "Jokes")
		
		do {
			let results = try managedContext.executeFetchRequest(fetchRequest)
			jokes = results as! [NSManagedObject]
		} catch let error as NSError {
			print("Could not fetch \(error), \(error.userInfo)")
		}
	}
	
	override func didReceiveMemoryWarning() {
		super.didReceiveMemoryWarning()
		// Dispose of any resources that can be recreated.
	}

	// MARK: UITableViewDataSource
	func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
		return jokes.count
	}
 
	func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
		
		let cell = tableView.dequeueReusableCellWithIdentifier("Cell")
		
		let joke = jokes[indexPath.row]
		cell!.textLabel!.text = joke.valueForKey( "text" ) as? String
		
		return cell!
	}
	

}