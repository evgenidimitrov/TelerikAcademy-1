using System;
using System.Collections.Generic;
using System.Linq;

namespace Task1
{
    class Teacher : Person, ICommentable
    {
        public List<Discipline> Discplines { get; set; }
               
        public Teacher(string name)
        {
            this.Discplines = new List<Discipline>();
            this.Name = name;
        }
        public List<string> Comments { get; set; }

        public void AddComment(string comment)
        {
            Comments.Add(comment);
        }
        
    }
}
