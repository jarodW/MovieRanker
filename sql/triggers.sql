DROP TRIGGER IF EXISTS MakePublicTrigger//
create trigger MakePublicTrigger
   BEFORE UPDATE ON lists
   FOR EACH ROW 
begin
   if(old.public != new.public) then
   insert into publiclist(listId, title, points)
   values(old.listId, old.title, 0);
   end if;
END; //