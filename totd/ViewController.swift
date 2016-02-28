//
//  ViewController.swift
//  totd
//
//  Created by Bill Snook on 2/25/16.
//  Copyright © 2016 BillSnook. All rights reserved.
//

import UIKit
import CoreData
import SwiftyJSON


let fontStyle = UIFontTextStyleHeadline


class ViewController: UIViewController {

	
	@IBOutlet weak var messageControl: UISegmentedControl!
	@IBOutlet weak var messageLabel: UILabel!
	
	var messagePath: String?
	var messageSelection: Int?
	

	override func viewDidLoad() {
		super.viewDidLoad()

#if	DEBUG
		log.debug( "debug mode set" )
#endif
		messageSelection = 0
		messageControl.selectedSegmentIndex = messageSelection!
		messageControl.setTitle( Utilities.messageLabel( 0 ), forSegmentAtIndex: 0 )
		messageControl.setTitle( Utilities.messageLabel( 1 ), forSegmentAtIndex: 1 )
		
		messagePath = Utilities.messageName( messageSelection! )
		log.debug( "intial message for app, message type selected is <\(messagePath)>" )
		
		
		messageLabel.font = UIFont.preferredFontForTextStyle(fontStyle)
		
		NSNotificationCenter.defaultCenter().addObserver(self,
			selector: "preferredContentSizeChanged:",
			name: UIContentSizeCategoryDidChangeNotification,
			object: nil)
	}

	override func viewWillAppear(animated: Bool) {
		
		updateMessage()
	}
	
	override func didReceiveMemoryWarning() {
		super.didReceiveMemoryWarning()
		// Dispose of any resources that can be recreated.
	}

	func preferredContentSizeChanged(notification: NSNotification) {
		messageLabel.font = UIFont.preferredFontForTextStyle(fontStyle)
		log.debug( "content size category changed" )
	}
	
	private func updateMessage() {
		
		Network.getJokeData( returnJokes )
		
	}
	
	func returnJokes( resultJokes: JSON?, index: Int ) -> () {
//		print( "Got result: \(resultJokes)" )
		
		if let jsonResult = resultJokes?[0] {
			manageJokes( jsonResult, index: index )
		} else {
			print( "No jokes returned" )
		}
		
	}
	
	func manageJokes( resultJokes: JSON, index: Int ) {
//		print( "manageJokes: \(resultJokes)" )
		
		let jotd = resultJokes["jotd"].stringValue
		
		self.messageLabel.text = jotd
		
		self.saveJoke( jotd, index: index )
	}

	func saveJoke(name: String, index: Int) {
		
		let appDelegate = UIApplication.sharedApplication().delegate as! AppDelegate
		
/**/
		let managedContext = appDelegate.managedObjectContext
		// See of joke (with id) already exists
		let fetch = NSFetchRequest( entityName: "Jokes" )
		let predicate = NSPredicate( format: "jidx == \(index)" )
		fetch.predicate = predicate

		do {
			let results = try managedContext.executeFetchRequest(fetch)
			if results.isEmpty {
				let entity =  NSEntityDescription.entityForName("Jokes", inManagedObjectContext: managedContext)
				let joke = NSManagedObject(entity: entity!, insertIntoManagedObjectContext: managedContext)
				joke.setValue(name, forKey: "text")
				joke.setValue(index, forKey: "jidx")
				
				do {
					try managedContext.save()
				} catch let error as NSError  {
					print("Could not save \(error), \(error.userInfo)")
				}
			}
		} catch let error as NSError {
			print("Could not fetch \(error), \(error.userInfo)")
		}

	}

	
	@IBAction func changeMessageType(sender: UISegmentedControl) {
		let segCtl = sender
		messageSelection = segCtl.selectedSegmentIndex
		messagePath = Utilities.messageName( messageSelection! )
		log.debug( "selected message type is now <\(segCtl.titleForSegmentAtIndex( messageSelection! )!)>" )
		updateMessage()
	}
	
}

