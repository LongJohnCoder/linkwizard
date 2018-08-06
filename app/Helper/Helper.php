<?php

	namespace App\Helper;
	use App\Url;
	class Helper {
		/*Method Will Return Total Click Count Of Group
		*
		*
		*/
		public static function getGroupTotalClickcount($groupId){
			$totalCount=0;
			$getGroup=Url::where('id',$groupId)->get();
			if(count($getGroup)>0){
				$getSubUrl=Url::where('parent_id',$groupId)->get();
				if(count($getSubUrl)>0){
					foreach ($getSubUrl as $key => $subUrl){
						$totalCount=$totalCount+$subUrl->count;
					}
				}
			}
			return $totalCount;
		}


	}
?>